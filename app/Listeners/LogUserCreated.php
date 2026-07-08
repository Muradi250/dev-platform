<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Services\ActivityLogger;

class LogUserCreated
{
    public function handle(Registered $event): void
    {
        ActivityLogger::log(
            'users.create',
            'User created: ' . $event->user->email
        );
    }
}