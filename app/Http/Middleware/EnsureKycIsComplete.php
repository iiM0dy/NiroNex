<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKycIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $kycComplete = !empty($user->id_photo_front) && !in_array($user->status, [\App\Enums\UserStatus::Pending, \App\Enums\UserStatus::Inactive]);

            if (!$kycComplete) {
                return redirect()->route('profile')->with('error', 'يجب استكمال توثيق الحساب (KYC) ومراجعته قبل التمكن من الإيداع أو المتابعة.');
            }
        }

        return $next($request);
    }
}
