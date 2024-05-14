<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request['updated_at'] = now();
        if ($request->filled('_l')) {
            Lang::setLocale($request->get('_l'));
        } else {
            Lang::setLocale(config('app.locale'));
        }

        $lang = Lang::getLocale();
        //        $request['lang_id'] = Language::getId($lang);
        $request['lang_code'] = $lang;

        return $next($request);
    }
}
