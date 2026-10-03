<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Password};
use Illuminate\Validation\ValidationException;
use Session;
use URL;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
    public function showLogin()
    {
        return view('auth.login');
    }
    public function showForgot()
    {
        return view('auth.password-forget');
    }
    public function showReset($token)
    {
        return view('auth.password-reset', ['token' => $token]);
    }

    public function register(RegisterRequest $request)
    {
        if (!$request->has('accept')) {
            return back()->with('error', 'يرجى الموافقة على شروط اتفاقية المستخدم.');
        }

        $birthdate = $this->normalizeBirthdate($request->birthdate);

        $referrerId = $request->referral_id;
        $referrer = $referrerId ? User::find($referrerId) : null;
        $ip = request()->ip();

        $attempts = DB::table('guest_users')
            ->where('referrer_id', $referrerId)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subDay())
            ->count();

        if ($attempts > 3) {
            return back()->with('error', ' كبير من المحاولات من نفس الجهاز.');
        }

        if ($referrer && $referrer->email === $request->email) {
            return back()->with('error', 'لا يمكنك استخدام رابط الإحالة الخاص بك للتسجيل.');
        }
        $user = User::create([
            'referrer_id' => $referrerId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $birthdate,
            'email' => $request->email,
            'phone' => ltrim($request->country_code . $request->phone, '+'),
            'password' => Hash::make($request->password),
            'status' => \App\Enums\UserStatus::Pending,
        ]);

        // Auto-verify and login — no email verification step
        $user->markEmailAsVerified();
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/trading');
    }

    private function normalizeBirthdate(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        foreach (['m/d/Y', 'Y-m-d'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);

                if ($date && $date->format($format) === $value) {
                    return $date->format('Y-m-d');
                }
            } catch (\Throwable $exception) {
                continue;
            }
        }

        return $value;
    }

    public function login(Request $request)
    {
        $request->validate(['identifier' => 'required|string', 'password' => 'required|string']);

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');

        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($fieldType, $identifier)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => ['البريد الإلكتروني أو رقم الهاتف أو كلمة المرور غير صحيحة.'],
            ]);
        }
        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();
        $user = auth()->user();

        // Auto-verify if not already verified
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        if ($user->is_admin) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/trading');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function demoLogin(Request $request)
    {
        // If user is already logged in, just redirect to trading
        if (Auth::check()) {
            return redirect()->route('site.trading');
        }

        $demoUser = User::create([
            'first_name' => 'Demo',
            'last_name' => 'User ' . rand(100, 999),
            'email' => 'demo_' . uniqid() . '@nironex.com',
            'phone' => '00000000' . rand(1000, 9999),
            'password' => Hash::make(uniqid()),
            'status' => \App\Enums\UserStatus::Active,
            'is_demo' => true,
            'trading_balance' => 0,
            'demo_trading_balance' => 50000.00,
        ]);

        $demoUser->markEmailAsVerified();

        Auth::guard('web')->login($demoUser, true);
        $request->session()->put(Auth::guard('web')->getName(), $demoUser->getAuthIdentifier());
        $request->session()->regenerate();
        $request->session()->save();

        return $this->demoTradingResponse($demoUser);
    }

    private function demoTradingResponse(User $user)
    {
        $activeTrades = $user->trades()->where('is_active', true)->latest()->get();
        $closedTrades = $user->trades()->where('is_active', false)->latest()->paginate(15);
        $priceChange = 12.50;
        $priceChangePct = 0.45;
        $normalizeTradingUrl = true;

        return view('site.trading', compact('user', 'activeTrades', 'closedTrades', 'priceChange', 'priceChangePct', 'normalizeTradingUrl'));
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink($request->only('email'));
        return back()->with('success', 'تم إرسال رابط استعادة كلمة المرور إلى بريدك الإلكتروني.');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            fn($user, $password) => $user->forceFill(['password' => Hash::make($password)])->save()
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'تم تعيين كلمة مرور جديدة بنجاح، يمكنك الآن تسجيل الدخول.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function verifyNotice()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (!hash_equals(sha1($user->email), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
            Auth::login($user, false);
            return redirect()->route('site.trading')->with('success', 'You have successfully verified your email.');
        }

        return redirect('/login')->with('success', 'You have successfully verified your email.');
    }

    public function resend(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('warning', 'تم التحقق من البريد مسبقاً.');
        }

        $user->sendEmailVerificationNotification();

        $resendLink = URL::temporarySignedRoute(
            'verification.send',
            now()->addMinutes(30),
            ['id' => $user->id]
        );
        session()->flash('resendLink', $resendLink);

        return redirect()->route('verification.notice');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }


    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        if ($user?->isDemoAccount() && ($request->filled('withdrawal_address') || $request->filled('address'))) {
            return back()->with('warning', 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'withdrawal_address' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date|before:today',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->withdrawal_address = $validated['withdrawal_address'] ?? $user->withdrawal_address;
        $user->address = $validated['address'] ?? $user->address;
        $user->birthday = $validated['birthday'] ?? $user->birthday;

        $user->save();

        return redirect()->back()->with('success', 'تم تحديث معلوماتك بنجاح.');
    }


    public function verifyKyc(Request $request)
    {
        $user = auth()->user();

        if ($user?->isDemoAccount()) {
            return back()->with('warning', 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.');
        }

        if ($user->id_photo_front) {
            return back()->with('error', 'لقد قمت برفع وثائق التحقق مسبقاً');
        }

        $validated = $request->validate([
            'document_type' => ['required', new \Illuminate\Validation\Rules\Enum(\App\Enums\IDPhotoType::class)],
            'id_photo_front' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'id_photo_back' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'selfie_with_document' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->id_photo_type = $validated['document_type'];
        $user->id_photo_front = $request->file('id_photo_front')->store('identity_documents');
        $user->id_photo_back = $request->file('id_photo_back')->store('identity_documents');
        $user->selfie_photo = $request->file('selfie_with_document')->store('selfies');
        $user->save();

        return back()->with('success', 'تم رفع وثائق التحقق بنجاح، سيتم مراجعتها قريباً');
    }

}
