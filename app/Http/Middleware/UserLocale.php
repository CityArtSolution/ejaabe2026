<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class UserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $generalSettings = getGeneralSettings();

        $defaultLocale = getDefaultLocale();

        $locale = $defaultLocale;

        if (auth()->check()) {
            $user = auth()->user();
            $locale = !empty($user->language) ? $user->language : $defaultLocale;
        } else {
            $checkCookie = Cookie::get('user_locale');

            if (!empty($checkCookie)) {
                $locale = $checkCookie;
            }
        }

        $userLanguages = $generalSettings['user_languages'] ?? [];

        // a language prefix in the url (/en/..., /ar/...) wins, and is remembered for pages without a prefix
        $urlLocale = mb_strtoupper((string)$request->segment(1));

        if (in_array($urlLocale, ['AR', 'EN']) and in_array($urlLocale, $userLanguages)) {
            if ($locale != $urlLocale and !auth()->check()) {
                Cookie::queue('user_locale', $urlLocale, 30 * 24 * 60);
            }

            $locale = $urlLocale;
        }

        if (!in_array($locale, $userLanguages)) {
            $locale = $defaultLocale;
        }

        \Session::put('locale', mb_strtolower($locale));

        return $next($request);
    }
}
