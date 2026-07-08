<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        ActivityLog::create([
            'user_id'     => $event->user?->id,
            'action'      => 'auth.logout',
            'description' => 'User logged out: ' . $event->user?->email,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}