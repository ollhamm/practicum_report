<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\LaporanPraktikum;

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
        // if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
        //     URL::forceScheme('https');
        // }

        // Share notification count untuk dosen
        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'dosen') {
                $unreviewedCount = LaporanPraktikum::whereHas('praktikum', function ($query) {
                    $query->where('dosen_id', Auth::id());
                })
                    ->where('status', 'submitted')
                    ->count();

                $view->with('unreviewedReportsCount', $unreviewedCount);
            }
        });
    }
}
