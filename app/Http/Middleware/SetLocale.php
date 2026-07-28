<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported application locales.
     */
    protected array $locales = [
        'en',
        'fa',
        'ps',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from URL route parameter
        $locale = $request->route('locale');

        // Check if locale is supported
        if (! in_array($locale, $this->locales)) {
            $locale = config('app.locale');
        }

        // Set application locale
        App::setLocale($locale);

        return $next($request);
    }
}