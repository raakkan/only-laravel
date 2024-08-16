<?php

namespace Raakkan\OnlyLaravel\Http\Middleware;

use Illuminate\Http\Request;
use Raakkan\OnlyLaravel\Setting\Models\Setting;

class OnlyLaravelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next)
    {
        $theme = Setting::getCurrentTheme();

        if ($request->expectsJson() || app()->runningInConsole()) {
            return $next($request);
        }

        // if (! is_null($theme)) {
        //     ThemesManager::set($theme);
        // } else {
        //     if ($theme = config('only-laravel::themes.fallback_theme')) {
        //         ThemesManager::set($theme);
        //     }
        // }

        return $next($request);
    }
}