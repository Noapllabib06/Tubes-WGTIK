<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\DetectDevice; // <-- Tambahkan baris ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Baris WAJIB untuk hosting seperti Railway/Cloudflare
        $middleware->trustProxies(at: '*'); 

        // 2. Middleware deteksi perangkat Anda
        $middleware->web(append: [
            \App\Http\Middleware\DetectDevice::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();