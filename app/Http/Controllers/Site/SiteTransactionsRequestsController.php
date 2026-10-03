<?php

namespace App\Http\Controllers\Site;

use App\Enums\TransactionRequestType;
use App\Enums\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequestRequest;
use App\Models\TransactionRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OtpService;
use Illuminate\Support\Facades\Cache;

class SiteTransactionsRequestsController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private OtpService $otpService)
    {
    }
    public function index(Request $request)
    {
        $search = $request->get('search');

        $query = TransactionRequest::where('user_id', Auth::id());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('created_at', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10);

        return view('site.transactions-requests.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        if ($this->isDemoAccount()) {
            return redirect()
                ->route('site.transactions-requests.index')
                ->with('warning', $this->demoWarning());
        }

        $typeParam = $request->query('t', 'w');

        if ($typeParam === 'd') {
            $transactionType = TransactionRequestType::Deposit->value;
        } elseif ($typeParam === 't') {
            $transactionType = TransactionRequestType::InternalTransfer->value;
        } else {
            $transactionType = TransactionRequestType::Withdrawal->value;
        }

        if ($this->requiresCompletedKyc($transactionType) && !Auth::user()?->hasCompletedKyc()) {
            return redirect()
                ->route('profile')
                ->with('error', $this->kycRequiredMessage());
        }

        return view('site.transactions-requests.create', compact('transactionType'));
    }

    public function store(StoreTransactionRequestRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->isDemoAccount($user)) {
            return redirect()
                ->route('site.transactions-requests.index')
                ->with('warning', $this->demoWarning());
        }

        $data['user_id'] = $user->id;

        if ($this->requiresCompletedKyc((int) $data['type']) && !$user->hasCompletedKyc()) {
            return redirect()
                ->route('profile')
                ->with('error', $this->kycRequiredMessage());
        }

        if ($request->file('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs');
            $data['image'] = $proofPath;
        }

        $data['wallet_type'] = WalletType::Profit;

        // Use OTP for Withdrawals
        if ($data['type'] === TransactionRequestType::Withdrawal->value || $data['type'] === TransactionRequestType::Withdrawal) {
            $cacheKey = 'withdrawal_request_' . $user->id;
            Cache::put($cacheKey, $data, now()->addMinutes(10));

            $this->otpService->send($user, 'withdrawal');

            return redirect()->route('site.transactions-requests.otp')
                ->with('info', 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.');
        }

        // For deposits or others, create directly
        TransactionRequest::create($data);

        return redirect()->route('site.transactions-requests.index')
            ->with('success', 'تم إرسال الطلب بنجاح');
    }

    public function verifyOtpShow()
    {
        if ($this->isDemoAccount()) {
            return redirect()
                ->route('site.transactions-requests.index')
                ->with('warning', $this->demoWarning());
        }

        if (!Auth::user()?->hasCompletedKyc()) {
            return redirect()->route('profile')
                ->withErrors(['amount' => 'يجب استكمال التحقق من الهوية قبل متابعة طلب السحب.']);
        }

        if (!Cache::has('withdrawal_request_' . Auth::id())) {
            return redirect()->route('site.transactions-requests.create')
                ->withErrors(['amount' => 'الجلسة انتهت أو لا يوجد طلب سحب معلق.']);
        }
        return view('site.transactions-requests.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($this->isDemoAccount($user)) {
            return redirect()
                ->route('site.transactions-requests.index')
                ->with('warning', $this->demoWarning());
        }

        if (!$user->hasCompletedKyc()) {
            return redirect()->route('profile')
                ->withErrors(['amount' => 'يجب استكمال التحقق من الهوية قبل متابعة طلب السحب.']);
        }

        if (!$this->otpService->verify($user->id, $request->code, 'withdrawal')) {
            return back()->withErrors(['code' => 'رمز التحقق غير صحيح أو منتهي الصلاحية.']);
        }

        $cacheKey = 'withdrawal_request_' . $user->id;
        $data = Cache::get($cacheKey);

        if (!$data) {
            return redirect()->route('site.transactions-requests.create')
                ->withErrors(['amount' => 'الجلسة انتهت، الرجاء إعادة المحاولة.']);
        }

        TransactionRequest::create($data);
        Cache::forget($cacheKey);

        return redirect()->route('site.transactions-requests.index')
            ->with('success', 'تم التحقق بنجاح وإرسال طلب السحب للإدارة.');
    }

    public function storeInternalTransfer(Request $request)
    {
        $request->validate([
            'receiver_email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:1|max:1000000000',
            // 'wallet_type' => ['required', new Enum(WalletType::class)],
            'note' => 'nullable|string|max:255',
        ], [
            'receiver_email.required' => 'البريد الإلكتروني للمستلم مطلوب.',
            'receiver_email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'receiver_email.exists' => 'لا يوجد حساب بهذا البريد الإلكتروني.',
            'amount.min' => 'المبلغ يجب أن يكون على الأقل ' . formatCurrency(1) . '.',
        ]);

        $receiver = User::where('email', $request->receiver_email)->first();
        $sender = auth()->user();

        if ($this->isDemoAccount($sender)) {
            return back()->with('warning', $this->demoWarning());
        }

        if (!$sender->hasCompletedKyc()) {
            return redirect()
                ->route('profile')
                ->with('error', $this->kycRequiredMessage());
        }

        if ($sender->id === $receiver->id) {
            return back()->withErrors(['receiver_email' => 'لا يمكنك تحويل الرصيد لنفسك.']);
        }

        // $senderWallet = $sender->wallets()->where('type', $request->wallet_type)->first();
        $senderWallet = $sender->profitWallet();

        if (!$senderWallet) {
            return back()->withErrors(['wallet_type' => 'المحفظة المختارة غير موجودة.']);
        }

        if ((float) $senderWallet->balance < (float) $request->amount) {
            return back()->withErrors(['amount' => 'الرصيد غير كاف.']);
        }

        TransactionRequest::create([
            'user_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'type' => TransactionRequestType::InternalTransfer,
            'method' => null,
            'amount' => $request->amount,
            'note' => $request->note,
            'transfer_data' => [
                'from_wallet_type' => WalletType::Profit->value,
            ],
        ]);

        return back()->with('success', 'تم إرسال طلب التحويل، بانتظار موافقة الإدارة.');
    }


    public function destroy($id)
    {
        $transactionRequest = TransactionRequest::findOrFail($id);

        $this->authorize('delete', $transactionRequest);

        $transactionRequest->delete();

        return redirect()->route('site.transactions-requests.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    private function isDemoAccount($user = null): bool
    {
        $user ??= Auth::user();

        return (bool) ($user?->isDemoAccount());
    }

    private function demoWarning(): string
    {
        return 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.';
    }

    private function requiresCompletedKyc(int $transactionType): bool
    {
        return in_array($transactionType, [
            TransactionRequestType::Withdrawal->value,
            TransactionRequestType::InternalTransfer->value,
        ], true);
    }

    private function kycRequiredMessage(): string
    {
        return 'يجب استكمال التحقق من الهوية قبل إرسال طلبات السحب أو التحويل الداخلي.';
    }

}
