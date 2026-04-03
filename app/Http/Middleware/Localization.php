<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      /*  if (!Session::has('locale'))
         {
           Session::put('locale', Config::get('app.locale'));
        }
        App::setLocale(Session::get('locale'));
        return $next($request);*/
        $locale = $request->segment(1);

  if ( ! array_key_exists($locale, app()->config->get('app.locales'))) {
    $segments = $request->segments();
    $segments[0] = app()->config->get('app.fallback_locale');

    return redirect()->to(implode('/', $segments));
  }

  app()->setLocale($locale);

  return $next($request);
    }
}