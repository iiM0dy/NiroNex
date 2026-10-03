<?php

namespace App\Http\Middleware;

use App\Enums\TransactionRequestType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirstDepositMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!auth()->check() || $user->requests->where('type', TransactionRequestType::Deposit)->count() == 0) {
            return redirect()->route('site.deposit');
        }
        return $next($request);
    }
}
