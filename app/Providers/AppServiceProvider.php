<?php

namespace App\Providers;

use App\Contracts\TranslationProvider;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use App\Models\User;
use App\Observers\UserObserver;
use App\Services\Translations\OpenAITranslationProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            TranslationProvider::class,
            OpenAITranslationProvider::class
        );
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Authentication events
        Event::listen(
            Login::class,
            LogSuccessfulLogin::class
        );

        Event::listen(
            Logout::class,
            LogSuccessfulLogout::class
        );

        // User activity logging
        User::observe(
            UserObserver::class
        );
    }
}