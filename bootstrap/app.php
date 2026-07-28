<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Custom Middleware Aliases
        |--------------------------------------------------------------------------
        |
        | Dev-Platform Middleware
        |
        */

        $middleware->alias([

            // Role Based Access Control
            'role' => \App\Http\Middleware\RoleMiddleware::class,

            // User Account Status Control
            'status' => \App\Http\Middleware\CheckUserStatus::class,

            // Multi Language Locale Management
            'setLocale' => \App\Http\Middleware\SetLocale::class,

            // Email Verification (Custom)
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Authentication Redirects
        |--------------------------------------------------------------------------
        |
        | Support Multi Language Routes
        |
        | Example:
        | /fa/login
        | /fa/dashboard
        |
        */

        // وقتی کاربر Login نیست
        $middleware->redirectGuestsTo(function (Request $request) {

            return route('login', [
                'locale' => app()->getLocale(),
            ]);

        });


        // وقتی کاربر قبلاً Login است
        $middleware->redirectUsersTo(function (Request $request) {

            return route('dashboard', [
                'locale' => app()->getLocale(),
            ]);

        });

    })


    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |--------------------------------------------------------------------------
        | API Exception Rendering
        |--------------------------------------------------------------------------
        */

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

    })

    ->create();