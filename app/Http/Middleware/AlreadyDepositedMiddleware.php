<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyDepositedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->deposit_balance > 0) {
            return redirect()->route('site.dashboard')->with('info', 'لقد قمت بالإيداع مسبقًا.');
        }

        return $next($request);
    }
}
