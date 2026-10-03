<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRobotSubscriber
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasRobotAccess()) {
            return redirect()
                ->route('site.dashboard')
                ->with('error', 'هذه الصفحة متاحة فقط لمشتركي خطة Robot.');
        }

        return $next($request);
    }
}
