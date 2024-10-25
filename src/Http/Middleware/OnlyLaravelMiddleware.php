<?php

namespace Raakkan\OnlyLaravel\Http\Middleware;

use Illuminate\Http\Request;

class OnlyLaravelMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, \Closure $next)
    {
        return $next($request);
    }
}
