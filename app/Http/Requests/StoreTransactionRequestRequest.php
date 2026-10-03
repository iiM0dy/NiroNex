<?php

namespace App\Http\Requests;

use App\Enums\TransactionRequestMethod;
use App\Enums\TransactionRequestType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreTransactionRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->user()?->isDemoAccount();
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            redirect()
                ->route('site.transactions-requests.index')
                ->with('warning', 'حساب الديمو للتجربة فقط. سجّل الدخول بحساب حقيقي أو أنشئ حساباً جديداً لاستخدام هذه الميزة.')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxBalance = auth()->user()->profit_balance ?? 0;
        $type = (int) $this->input('type');
        $minimumAmount = $this->minimumAmount();

        $requiresMethod = in_array($type, [
            TransactionRequestType::Deposit->value,
            TransactionRequestType::Withdrawal->value,
        ], true);

        $allowedMethods = match ($type) {
            TransactionRequestType::Deposit->value => TransactionRequestMethod::depositValues(),
            TransactionRequestType::Withdrawal->value => TransactionRequestMethod::withdrawalValues(),
            default => [],
        };

        return [
            'type' => ['required'],
            'method' => [
                Rule::requiredIf($requiresMethod),
                Rule::in($allowedMethods),
            ],
            'amount' => [
                'required',
                'numeric',
                'min:' . $minimumAmount,
                'max:1000000000', // Hard cap at 1 Billion to prevent DB overflow regardless of column size
                Rule::when($this->type == TransactionRequestType::Withdrawal->value, ['max:' . $maxBalance]),
                Rule::when($this->type == TransactionRequestType::InternalTransfer->value, ['max:' . $maxBalance]),
            ],
            // 'wallet_type' => ['nullable', Rule::requiredIf(fn() => $this->type == TransactionRequestType::Withdrawal->value)],
            'transfer_data' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'نوع العملية مطلوب.',
            'method.required' => 'طريقة التحويل مطلوبة.',
            'method.in' => 'طريقة التحويل المختارة غير صحيحة.',
            'amount.required' => 'المبلغ مطلوب.',
            'amount.numeric' => 'المبلغ يجب أن يكون رقمًا.',
            'amount.min' => 'المبلغ يجب أن يكون على الأقل ' . formatCurrency($this->minimumAmount()) . '.',
            'amount.max' => $this->amountMaxMessage(),
            'transfer_data.required' => 'بيانات التحويل مطلوبة.',
            'transfer_data.wallet_address.required' => 'عنوان المحفظة مطلوب لـ USDT.',
        ];
    }

    private function minimumAmount(): int
    {
        return (int) $this->input('type') === TransactionRequestType::Deposit->value ? 20 : 1;
    }

    private function amountMaxMessage(): string
    {
        if ((int) $this->input('type') === TransactionRequestType::Deposit->value) {
            return 'المبلغ يجب ألا يتجاوز ' . formatCurrency(1000000000) . '.';
        }

        return 'الرصيد غير كاف لهذه العملية. رصيدك الحالي هو ' . formatCurrency(auth()->user()->profit_balance ?? 0);
    }


    public static function getTransferDataLabels(TransactionRequestMethod|int|null $method = null): array
    {
        $method = is_int($method) ? TransactionRequestMethod::from($method) : $method;
        return [
            'wallet_address' => ['label' => 'عنوان المحفظة', 'type' => 'text'],
        ];
    }
}
