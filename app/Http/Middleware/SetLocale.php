<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = config('app.locale'); // default locale

        // إذا المستخدم مسجل دخول
        if (Auth::check() && !empty(Auth::user()->language)) {
            $locale = Auth::user()->language;
        }
        // إذا في كوكي
        elseif ($request->hasCookie('user_locale')) {
            $locale = $request->cookie('user_locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
