<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\TransactionRequest;
use App\Observers\TransactionObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (request()->header('X-Forwarded-Proto') === 'https' || request()->secure()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Transaction::observe(TransactionObserver::class);
        Paginator::useBootstrapFive();

        View::composer('site.includes.site-footer', function ($view) {
            $view->with('footerSettings', Setting::footer());
        });
    }
}
