<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $birthdate = $this->parseBirthdate((string) $value);

                    if (!$birthdate) {
                        $fail('يرجى إدخال تاريخ الميلاد بصيغة MM/DD/YYYY.');
                        return;
                    }

                    if ($birthdate->greaterThanOrEqualTo(now()->subYears(14)->startOfDay())) {
                        $fail('يجب أن يكون عمر المستخدم 14 سنة على الأقل.');
                    }
                },
            ],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric'],
            'country_code' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:6'],
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required' => 'الاسم الثاني مطلوب',
            'birthdate.required' => 'تاريخ الميلاد مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
        ];
    }

    private function parseBirthdate(string $value): ?Carbon
    {
        foreach (['m/d/Y', 'Y-m-d'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);

                if ($date && $date->format($format) === $value) {
                    return $date;
                }
            } catch (\Throwable $exception) {
                continue;
            }
        }

        return null;
    }
}
