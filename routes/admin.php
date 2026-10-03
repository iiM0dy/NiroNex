<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessagesController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTransactionRequestController;
use App\Http\Controllers\Admin\AdminTransactionsController;
use App\Http\Controllers\Admin\AdminUsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth', 'is.admin'])->prefix('admin/')->name('admin.')->group(function () {

    Route::get('dashboard/profits/logs', function () {
        $path = storage_path('logs/profits.log');

        if (!File::exists($path)) {
            return response()->json([]);
        }

        $lines = array_slice(explode(PHP_EOL, File::get($path)), -50);
        $lines = array_filter($lines);

        return response()->json(array_reverse($lines));
    })->name('dashboard.profits.logs');

    Route::get('files/{path}', function (string $path) {
        $path = ltrim($path, '/');

        abort_if(str_contains($path, '..'), 404);
        abort_unless(str_starts_with($path, 'identity_documents/')
            || str_starts_with($path, 'selfies/')
            || str_starts_with($path, 'payment_proofs/'), 404);
        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    })->where('path', '.*')->name('files.show');

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('verification-kyc', [AdminUsersController::class, 'verificationKyc'])->name('verification-kyc.index');
    Route::post('verification-kyc/{id}/approve', [AdminUsersController::class, 'approveKyc'])->name('verification-kyc.approve');
    Route::post('verification-kyc/{id}/reject', [AdminUsersController::class, 'rejectKyc'])->name('verification-kyc.reject');

    Route::get('robot-requests', [AdminTransactionRequestController::class, 'robotRequests'])->name('robot-requests.index');

    Route::prefix('transactions-requests/')->name('transactions-requests.')
        ->controller(AdminTransactionRequestController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('approve/{id}', 'approve')->name('approve');
            Route::post('reject/{id}', 'reject')->name('reject');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::get('internal-transfer', 'internalTransfer')->name('internal-transfer');
            Route::get('create-internal-transfer', 'createInternalTransfer')->name('create-internal-transfer');
            Route::post('create-internal-transfer', 'storeInternalTransfer')->name('store-internal-transfer');
        });

    Route::prefix('transactions/')->name('transactions.')
        ->controller(AdminTransactionsController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::put('/{id}', 'update')->name('update');
        });

    Route::prefix('settings')->name('settings.')
        ->controller(AdminSettingController::class)->group(function () {
            Route::get('footer', 'editFooter')->name('footer.edit');
            Route::put('footer', 'updateFooter')->name('footer.update');
        });

    Route::prefix('users/')->name('users.')
        ->controller(AdminUsersController::class)->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('{id}', 'show')->name('show');
            Route::delete('{id}', 'destroy')->name('destroy');
            Route::post('{id}/status', 'updateStatus')->name('update-status');
            Route::post('{id}/wallet', 'updateDepositWallet')->name('update-wallet');
        });

    Route::prefix('messages/')->name('messages.')
        ->controller(AdminMessagesController::class)->group(function () {
            Route::get('/0', 'index')->name('index');
            Route::get('/0/recommendations', 'recommendationsShow')->name('recommendations');
            Route::post('/0/sendRecommendations', 'sendRecommendations')->name('recommendations-post');
            Route::get('/{user}', 'userChat')->name('chat');
        });

    Route::prefix('api/messages/')->name('api.messages.')
        ->controller(AdminMessagesController::class)->group(function () {
            Route::get('/fetch', 'fetch')->name('fetch');
            Route::post('/send', 'send')->name('send');
        });

});
