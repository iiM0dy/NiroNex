<?php

namespace App\Rules;

use App\Models\Plan;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDepositAmount implements ValidationRule
{
    protected $planId;

    public function __construct($planId)
    {
        $this->planId = $planId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $plan = Plan::find($this->planId);

        if (!$plan) {
            $fail('الخطة المحددة غير موجودة.');
            return;
        }

        if ($value < $plan->min_deposit) {
            $fail('قيمة الإيداع يجب أن تبدأ من ' . formatCurrency($plan->min_deposit) . ' لهذه الباقة.');
            return;
        }

        if (!$plan->hasUnlimitedMaxDeposit() && $value > $plan->max_deposit) {
            $fail('قيمة الإيداع يجب أن تكون بين ' . formatCurrency($plan->min_deposit) . ' و ' . formatCurrency($plan->max_deposit) . ' لهذه الباقة.');
        }
    }
}
