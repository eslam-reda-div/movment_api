<?php

namespace App\Http\Middleware;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (LanguageSwitch::make()->getPreferredLocale() !== null && LanguageSwitch::make()->getPreferredLocale() !== 'en') {
            app()->setLocale(
                locale: LanguageSwitch::make()->getPreferredLocale()
            );
        } else {
            app()->setLocale(
                locale: 'en_us'
            );
        }

        return $next($request);
    }
}
