<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetAdminLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {


        /*
        |--------------------------------------------------------------------------
        | دریافت زبان ذخیره شده پنل
        |--------------------------------------------------------------------------
        */

        $locale = session('admin_locale', config('app.locale'));

        /*
        |--------------------------------------------------------------------------
        | اعمال زبان
        |--------------------------------------------------------------------------
        */

        if (in_array($locale, [
            'en',
            'fa',
            'ps',
        ])) {
            App::setLocale($locale);

            config([
                'app.locale' => $locale,
            ]);
        }



        return $next($request);

    }
}