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

        // 1. FITUR OVERRIDE (Untuk memaksa ganti tampilan lewat URL / Testing)
        if ($request->query('device') === 'mobile') {
            $isMobile = true;
        } elseif ($request->query('device') === 'desktop') {
            $isMobile = false;
        } 
        // 2. DETEKSI OTOMATIS (Membaca Proxy Railway)
        else {
            // Railway terkadang menaruh User-Agent asli di header X-Forwarded
            $originalUserAgent = $request->header('X-Forwarded-User-Agent') ?: $request->userAgent();
            
            if ($request->header('Sec-CH-UA-Mobile') === '?1') {
                $isMobile = true;
            } else {
                $agent = new Agent();
                $agent->setUserAgent($originalUserAgent);
                
                if ($agent->isMobile() || $agent->isTablet()) {
                    $isMobile = true;
                }
            }
        }

        // 3. ARAHKAN FOLDER & RESET MEMORI PENCARIAN VIEW
        $viewFinder = View::getFinder();
        $viewFinder->flush(); // PAKSA Laravel melupakan path view sebelumnya

        if ($isMobile) {
            $viewFinder->prependLocation(resource_path('views/mobile'));
        } else {
            $viewFinder->prependLocation(resource_path('views/desktop'));
        }

        return $next($request);
    }
}