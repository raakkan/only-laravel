<?php

namespace Raakkan\OnlyLaravel\Http\Middleware;

use Illuminate\Http\Request;
use Raakkan\ThemesManager\Models\ThemeSetting;

class OnlyLaravelMiddleware extends ThemeLoader
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next, ?string $theme = null)
    {
        $theme = ThemeSetting::getCurrentTheme();

        return parent::handle($request, $next, $theme);
    }
}