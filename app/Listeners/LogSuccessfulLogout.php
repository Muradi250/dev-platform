<?php

namespace App\Listeners;

use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Model;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        $user = $event->user;

        ActivityLogger::log(
            action: 'auth.logout',
            description: 'User logged out: ' . ($user?->email ?? 'unknown'),
            model: $user instanceof Model ? $user : null,
            context: [
                'user_id' => $user?->getAuthIdentifier(),
                'email' => $user?->email,
            ],
            category: 'security',
            severity: 'info',
            icon: 'heroicon-o-arrow-left-start-on-rectangle',
            module: 'auth',
            actorId: $user ? (int) $user->getAuthIdentifier() : null,
        );
    }
}