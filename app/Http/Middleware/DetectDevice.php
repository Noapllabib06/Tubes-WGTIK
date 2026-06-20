<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\View;

class DetectDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent();
        
        // --- PERBAIKAN UNTUK HOSTING / RAILWAY ---
        // Memaksa Agent untuk membaca User-Agent dari header Laravel Request
        $agent->setUserAgent($request->header('User-Agent'));

        $viewFinder = View::getFinder();

        // Cek apakah pengunjung menggunakan HP atau Tablet
        if ($agent->isMobile() || $agent->isTablet()) {
            $viewFinder->prependLocation(resource_path('views/mobile'));
        } else {
            $viewFinder->prependLocation(resource_path('views/desktop'));
        }

        return $next($request);
    }
}