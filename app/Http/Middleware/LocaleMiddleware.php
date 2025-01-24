<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language');
        $availableLocales = ['en', 'ru', 'kk'];

        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
        } else {
            App::setLocale(config('app.locale')); // Язык по умолчанию
        }

        return $next($request);
    }
}
