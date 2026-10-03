<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleReferralMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ref = $request->query('ref');
        if ($ref && !$request->session()->has('referrer')) {
            $referrer = User::find($ref);
            if ($referrer) {
                $request->session()->put('referrer', $referrer->id);

                DB::table('guest_users')->insert([
                    'referrer_id' => $referrer->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'created_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}
