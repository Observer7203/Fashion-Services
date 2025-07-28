<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocaleFromUrl
{
    public function handle($request, Closure $next)
    {
        $locale = $request->route('locale'); // достаём {locale} из маршрута
        if (in_array($locale, ['ru', 'en'])) {
            App::setLocale($locale);
        }
        return $next($request);
    }
}
