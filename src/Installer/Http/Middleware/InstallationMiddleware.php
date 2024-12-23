<?php

namespace Raakkan\OnlyLaravel\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(file_exists(storage_path('only-laravel/installed'))) {
            return redirect()->to('/');
        }
        // Skip check for installer routes
        if ($request->is('install*')) {
            return $next($request);
        }

        // If not installed, redirect to installer
        if (!file_exists(storage_path('only-laravel/installed'))) {
            return redirect()->to('/installer');
        }

        return $next($request);
    }
} 