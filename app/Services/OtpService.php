<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * OTP Service — handles OTP generation, storage, and verification.
 *
 * Delivery channel is abstracted: currently sends via email.
 * To switch to SMS later, implement a new send method and swap
 * the call in `send()` without touching the rest of the flow.
 */
class OtpService
{
    /** OTP validity in minutes */
    private const TTL_MINUTES = 10;

    /** OTP length */
    private const CODE_LENGTH = 6;

    /**
     * Generate and send an OTP for a given purpose.
     *
     * @param  \App\Models\User  $user
     * @param  string  $purpose  e.g. 'withdrawal', 'login'
     * @return bool
     */
    public function send($user, string $purpose = 'withdrawal'): bool
    {
        $code = $this->generateCode();
        $cacheKey = $this->cacheKey($user->id, $purpose);

        Cache::put($cacheKey, $code, now()->addMinutes(self::TTL_MINUTES));

        return $this->sendViaEmail($user, $code, $purpose);
    }

    /**
     * Verify an OTP code.
     *
     * @param  int     $userId
     * @param  string  $code
     * @param  string  $purpose
     * @return bool
     */
    public function verify(int $userId, string $code, string $purpose = 'withdrawal'): bool
    {
        $cacheKey = $this->cacheKey($userId, $purpose);
        $stored = Cache::get($cacheKey);

        if ($stored && $stored === $code) {
            Cache::forget($cacheKey);
            return true;
        }

        return false;
    }

    /**
     * Generate a random numeric OTP code.
     */
    private function generateCode(): string
    {
        return str_pad((string) random_int(0, (int) str_repeat('9', self::CODE_LENGTH)), self::CODE_LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * Cache key for storing OTP.
     */
    private function cacheKey(int $userId, string $purpose): string
    {
        return "otp:{$purpose}:{$userId}";
    }

    /**
     * Send OTP via email.
     * To switch to SMS: create a `sendViaSms()` method and call it instead.
     */
    private function sendViaEmail($user, string $code, string $purpose): bool
    {
        try {
            Mail::raw(
                "رمز التحقق الخاص بك هو: {$code}\nصالح لمدة " . self::TTL_MINUTES . " دقائق.\nلا تشارك هذا الرمز مع أي شخص.",
                function ($message) use ($user, $purpose) {
                    $message->to($user->email)
                        ->subject(appName() . ' - رمز التحقق ' . ($purpose === 'withdrawal' ? 'للسحب' : ''));
                }
            );
            return true;
        } catch (\Exception $e) {
            Log::error('OTP Email Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * PLACEHOLDER: Send OTP via SMS.
     * Uncomment and implement when SMS gateway is ready.
     *
     * private function sendViaSms($user, string $code, string $purpose): bool
     * {
     *     // TODO: Integrate with SMS provider (Twilio, Vonage, etc.)
     *     // $smsService->send($user->phone, "رمز التحقق: {$code}");
     *     return false;
     * }
     */
}
