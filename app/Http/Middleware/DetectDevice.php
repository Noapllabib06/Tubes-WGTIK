<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\View;

class DetectDevice
{
    public function handle(Request $request, Closure $next): Response
    {
        $isMobile = false;

        // 1. Deteksi Super Akurat: Cek header 'Sec-CH-UA-Mobile' (Standar Browser HP Modern)
        // Header ini kebal terhadap proxy dan load balancer seperti milik Railway/Cloudflare
        if ($request->header('Sec-CH-UA-Mobile') === '?1') {
            $isMobile = true;
        } 
        // 2. Deteksi Fallback: Menggunakan library Agent membaca User-Agent
        else {
            $agent = new Agent();
            // Gunakan $request->userAgent() bawaan Laravel yang lebih peka terhadap Proxy
            $agent->setUserAgent($request->userAgent());
            
            if ($agent->isMobile() || $agent->isTablet()) {
                $isMobile = true;
            }
        }

        // 3. Arahkan Folder Tampilan
        $viewFinder = View::getFinder();
        if ($isMobile) {
            $viewFinder->prependLocation(resource_path('views/mobile'));
        } else {
            $viewFinder->prependLocation(resource_path('views/desktop'));
        }

        return $next($request);
    }
}