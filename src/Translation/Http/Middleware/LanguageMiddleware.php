<?php

namespace Raakkan\OnlyLaravel\Translation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Raakkan\OnlyLaravel\Translation\Models\Language;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if ($request->user()) {
            if (!empty($request->user()->settings->lang)) {
                app()->setLocale($request->user()->settings->lang);
            } else {
                if(session()->has('locale')){
                    app()->setLocale(session()->get('locale', 'en'));
                }else {
                    $Language = Language::getDefaultLanguage();
                    if (!empty($Language)) {
                        app()->setLocale($Language->locale);
                    }else{
                        app()->setLocale('en');
                    }
                }
            }
        }else {
            if(session()->has('locale')){
                app()->setLocale(session()->get('locale', 'en'));
            }else {
                $Language = Language::getDefaultLanguage();
                if (!empty($Language)) {
                    app()->setLocale($Language->locale);
                }else{
                    app()->setLocale('en');
                }
            }
        }
        return $next($request);
    }
}
