<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ActivityLogger;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        ActivityLogger::log(
            'auth.login',
            'User logged in: ' . $event->user->email
        );
    }
}