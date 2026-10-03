<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->status !== UserStatus::Active) {
            return redirect()->route('site.dashboard')->with('error', 'حسابك غير مفعل، لا يمكنك الوصول لهذه الصفحة.');
        }

        return $next($request);
    }
}
