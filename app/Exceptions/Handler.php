<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Cookie;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'resendLink',
    ];

    public function register(): void
    {
        $this->renderable(function (TokenMismatchException $e, $request) {
            return redirect('/login')
                ->withCookie(Cookie::forget(config('session.cookie')))
                ->with('error', 'انتهت الجلسة. الرجاء تسجيل الدخول من جديد.');
        });
    }
}
