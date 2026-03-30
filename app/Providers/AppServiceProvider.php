<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Baris ini sudah benar

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
        // Karena sudah ada 'use' di atas, hapus tanda '\' di depan URL
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}