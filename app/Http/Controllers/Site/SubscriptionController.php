<?php

namespace App\Http\Controllers\Site;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $plans = Plan::query()->accountPlans()->get();
        $availableBalance = (float) ($user->depositWallet?->balance ?? 0);

        return view('site.plans', compact('plans', 'user', 'availableBalance'));
    }

    public function subscribe(Request $request, Plan $plan)
    {
        $user = Auth::user();

        if ($user?->isDemoAccount()) {
            return redirect()
                ->route('site.plans')
                ->with('warning', 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.');
        }

        if ($plan->isRobotPlan()) {
            return redirect()
                ->route('site.plans')
                ->with('error', 'هذه الخطة خاصة بالروبوت. استخدم صفحة الروبوت لتفعيلها.');
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $plan->min_deposit],
        ], [
            'amount.required' => 'يرجى إدخال مبلغ الاشتراك.',
            'amount.numeric' => 'مبلغ الاشتراك يجب أن يكون رقماً.',
            'amount.min' => 'مبلغ الاشتراك يجب أن يبدأ من ' . formatCurrency($plan->min_deposit) . '.',
        ]);

        $amount = round((float) $validated['amount'], 2);

        if (!$plan->hasUnlimitedMaxDeposit() && $amount > (float) $plan->max_deposit) {
            return back()
                ->withInput()
                ->with('error', 'مبلغ الاشتراك يجب أن لا يتجاوز ' . formatCurrency($plan->max_deposit) . ' لهذه الخطة.');
        }

        try {
            DB::transaction(function () use ($user, $plan, $amount) {
                $depositWallet = $user->depositWallet()->lockForUpdate()->first();

                if (!$depositWallet || (float) $depositWallet->balance < $amount) {
                    throw new \RuntimeException('رصيد المحفظة غير كافٍ للاشتراك في هذه الخطة. قم بالإيداع أولاً ثم حاول مرة أخرى.');
                }

                Transaction::create([
                    'wallet_id' => $depositWallet->id,
                    'type' => TransactionType::PlanSubscription,
                    'status' => TransactionStatus::Accepted,
                    'amount' => $amount,
                    'description' => 'اشتراك في خطة ' . $plan->display_name,
                    'transaction_date' => now(),
                ]);

                $user->plan_id = $plan->id;
                $user->plan_amount = round(((float) $user->plan_amount) + $amount, 2);
                $user->last_profit_date = now();
                $user->save();
            });
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('site.plans')
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('site.plans')
            ->with('success', 'تم الاشتراك في خطة ' . $plan->display_name . ' بنجاح بمبلغ ' . formatCurrency($amount) . '.');
    }
}
