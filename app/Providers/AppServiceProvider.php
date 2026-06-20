<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambahkan baris ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Memaksa Laravel menggunakan HTTPS jika di-deploy ke Railway/Production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}