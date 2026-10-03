<?php

namespace App\Http\Requests;

use App\Enums\TransactionRequestMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class DepositRequest extends FormRequest
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
                ->route('site.deposit')
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
        return [
            'plan_id' => ['nullable', 'exists:plans,id'],
            'amount' => ['required', 'numeric', 'min:20'],
            'payment_method' => ['required', Rule::in(TransactionRequestMethod::depositValues())],
            'payment_proof' => ['required', 'image', 'max:50000'],
        ];
    }

    public function messages()
    {
        return [
            'plan_id.exists' => 'الباقة المختارة غير موجودة.',
            'amount.required' => 'يرجى إدخال مبلغ الإيداع.',
            'amount.numeric' => 'المبلغ يجب أن يكون رقمًا صحيحًا.',
            'amount.min' => 'المبلغ يجب أن يكون على الأقل ' . formatCurrency(20) . '.',
            'payment_method.required' => 'يرجى اختيار طريقة الدفع.',
            'payment_method.in' => 'طريقة الدفع غير صحيحة.',
            'payment_proof.required' => 'يرجى إرفاق إثبات الدفع.',
            'payment_proof.image' => 'إثبات الدفع يجب أن يكون صورة.',
            'payment_proof.max' => 'حجم صورة إثبات الدفع يجب أن لا يتجاوز 5 ميغابايت.',
        ];
    }

}
