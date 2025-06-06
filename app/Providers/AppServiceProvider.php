<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS untuk semua URL
        // if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
        //     URL::forceScheme('https');
        // }
    }
}
