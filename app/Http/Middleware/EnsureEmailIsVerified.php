<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            ! $user ||
            ! ($user instanceof MustVerifyEmail) ||
            $user->hasVerifiedEmail()
        ) {
            return $next($request);
        }

        return Redirect::route('verification.notice', [
            'locale' => app()->getLocale(),
        ]);
    }
}