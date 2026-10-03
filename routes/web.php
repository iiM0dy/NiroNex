<?php

use App\Http\Controllers\Site\CopyTradingController;
use App\Http\Controllers\Site\NotificationController;
use App\Http\Controllers\Site\PerformanceController;
use App\Http\Controllers\Site\RobotController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\SiteMessagesController;
use App\Http\Controllers\Site\SiteReferController;
use App\Http\Controllers\Site\SiteTransactionsController;
use App\Http\Controllers\Site\SiteTransactionsRequestsController;
use App\Http\Controllers\Site\SubscriptionController;
use App\Http\Controllers\Site\TradingController;
use App\Http\Controllers\Site\WalletController;
use Illuminate\Support\Facades\Route;

Route::view('/terms', 'site.terms')->name('terms');
Route::match(['get', 'post'], '/demo-login', [\App\Http\Controllers\AuthController::class, 'demoLogin'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('demo.login');

Route::name('site.')->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('index');
    Route::get('/trading', [TradingController::class, 'index'])->name('trading');

    Route::middleware(['auth'])->group(function () {
        Route::get('/deposit', [SiteController::class, 'depositShow'])->name('deposit');
        Route::post('/deposit', [SiteController::class, 'deposit']);
        Route::get('/funding', [SiteController::class, 'fundingShow'])->name('funding');
        Route::post('/funding', [SiteController::class, 'fundingStore'])->name('funding.store');
        Route::post('/reviews', [SiteController::class, 'storeReview'])->name('reviews.store');

        Route::get('/dashboard', [SiteController::class, 'dashboard'])->name('dashboard');

        Route::prefix('transactions-requests')->name('transactions-requests.')->group(function () {
            Route::get('/', [SiteTransactionsRequestsController::class, 'index'])->name('index');
            Route::get('/create', [SiteTransactionsRequestsController::class, 'create'])->name('create')->middleware('active_user');
            Route::get('/otp', [SiteTransactionsRequestsController::class, 'verifyOtpShow'])->name('otp')->middleware('active_user');
            Route::post('/otp', [SiteTransactionsRequestsController::class, 'verifyOtp'])->name('otp.verify')->middleware(['active_user', 'throttle:10,1']);
            Route::post('/internal-transfer', [SiteTransactionsRequestsController::class, 'storeInternalTransfer'])->name('store.internal-transfer')->middleware('active_user');
            Route::post('/', [SiteTransactionsRequestsController::class, 'store'])->name('store')->middleware(['active_user', 'throttle:10,1']);
            Route::delete('/{id}', [SiteTransactionsRequestsController::class, 'destroy'])->name('destroy')->middleware('active_user');
        });

        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [SiteTransactionsController::class, 'index'])->name('index');
        });

        Route::prefix('messages/')->name('messages.')
            ->controller(SiteMessagesController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/send', 'store')->name('send');
                Route::get('/recommendations', 'recommendations')->name('recommendations')->middleware('active_user');
            });

        Route::prefix('api/messages/')->name('api.messages.')
            ->controller(SiteMessagesController::class)->group(function () {
                Route::get('/fetch', 'fetch')->name('fetch');
                Route::post('/send', 'send')->name('send');
            });

        Route::prefix('refers/')->name('refers.')->middleware('active_user')
            ->controller(SiteReferController::class)->group(function () {
                Route::get('/', 'index')->name('index');
            });

        Route::get('/trading/history', [TradingController::class, 'history'])->name('trading.history');
        Route::post('/trading/open', [TradingController::class, 'openTrade'])->name('trading.open');
        Route::post('/trading/close/{ticket}', [TradingController::class, 'closeTrade'])->name('trading.close');
        Route::post('/trading/fund', [TradingController::class, 'transferToTrading'])->name('trading.fund');
        Route::post('/trading/withdraw', [TradingController::class, 'transferFromTrading'])->name('trading.withdraw')->middleware('active_user');

        Route::prefix('copy-trading')->name('copy-trading.')->group(function () {
            Route::get('/', [CopyTradingController::class, 'index'])->name('index');
            Route::post('/', [CopyTradingController::class, 'update'])->name('update');
        });

        Route::prefix('robot')->name('robot.')->group(function () {
            Route::get('/', [RobotController::class, 'index'])->name('index');
            Route::post('/', [RobotController::class, 'update'])->name('update');
        });

        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
        Route::get('/plans', [SubscriptionController::class, 'index'])->name('plans');
        Route::post('/plans/{plan}/subscribe', [SubscriptionController::class, 'subscribe'])->name('plans.subscribe');
        Route::get('/performance', [PerformanceController::class, 'index'])->name('performance');

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/{id}/read', [NotificationController::class, 'markRead'])->name('read');
            Route::get('/unread', [NotificationController::class, 'fetchUnread'])->name('unread');
        });
    });
});
