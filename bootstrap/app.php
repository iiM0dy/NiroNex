<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AlreadyDepositedMiddleware;
use App\Http\Middleware\CheckUserActive;
use App\Http\Middleware\FirstDepositMiddleware;
use App\Http\Middleware\HandleReferralMiddleware;
use App\Http\Middleware\EnsureKycIsComplete;
use App\Http\Middleware\EnsureRobotSubscriber;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [__DIR__ . '/../routes/web.php', __DIR__ . '/../routes/admin.php', __DIR__ . '/../routes/auth.php'],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->validateCsrfTokens(except: [
            'demo-login',
        ]);

        $middleware->alias([
            'is.admin' => AdminMiddleware::class,
            'is.deposited' => FirstDepositMiddleware::class,
            'referral' => HandleReferralMiddleware::class,
            'active_user' => CheckUserActive::class,
            'kyc.completed' => EnsureKycIsComplete::class,
            'robot.plan' => EnsureRobotSubscriber::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
