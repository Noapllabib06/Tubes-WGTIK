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
        $viewFinder = View::getFinder();

        // Cek apakah pengunjung menggunakan HP atau Tablet
        if ($agent->isMobile() || $agent->isTablet()) {
            // Prioritaskan pencarian file view di folder 'mobile'
            $viewFinder->prependLocation(resource_path('views/mobile'));
        } else {
            // Prioritaskan pencarian file view di folder 'desktop'
            $viewFinder->prependLocation(resource_path('views/desktop'));
        }

        return $next($request);
    }
}