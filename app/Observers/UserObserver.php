<?php

namespace App\Observers;

use App\Models\User;
use App\Services\ActivityLogger;

class UserObserver
{
    public function created(User $user): void
    {
        ActivityLogger::log(
            action: 'users.create',
            description: 'User created: ' . $user->name . ' | Email: ' . $user->email,
            category: 'users',
            severity: 'info',
            icon: 'heroicon-o-user-plus',
            module: 'core',
            model: $user,
            context: [
                'email' => $user->email,
                'created_at' => now()->toDateTimeString(),
            ]
        );
    }

    public function updated(User $user): void
    {
        $changes = $user->getChanges();

        ActivityLogger::log(
            action: 'users.update',
            description: 'User updated: ' . $user->name,
            category: 'users',
            severity: 'warning',
            icon: 'heroicon-o-pencil-square',
            module: 'core',
            model: $user,
            context: [
                'changes' => $changes,
                'updated_fields' => array_keys($changes),
            ]
        );
    }

    public function deleting(User $user): void
    {
        // 🔥 FIX مهم: گرفتن roles به صورت مستقیم (safe)
        $roles = $user->roles()
            ->pluck('name')
            ->toArray();

        ActivityLogger::log(
            action: 'users.delete',
            description: 'User deleted: ' . $user->name . ' | Email: ' . $user->email,
            category: 'users',
            severity: 'danger',
            icon: 'heroicon-o-trash',
            module: 'core',
            model: $user,
            context: [
                'email' => $user->email,
                'roles' => $roles,
            ]
        );
    }

    public function deleted(User $user): void
    {
        ActivityLogger::log(
            action: 'users.delete.confirmed',
            description: 'User deletion completed: ' . $user->id,
            category: 'system',
            severity: 'danger',
            icon: 'heroicon-o-check-circle',
            module: 'core',
            context: [
                'user_id' => $user->id,
            ]
        );
    }

    public function restored(User $user): void
    {
        ActivityLogger::log(
            action: 'users.restore',
            description: 'User restored: ' . $user->name,
            category: 'users',
            severity: 'info',
            icon: 'heroicon-o-arrow-path',
            module: 'core',
            model: $user
        );
    }

    public function forceDeleted(User $user): void
    {
        // 🔥 FIX: safe roles fetch (same reason as deleting)
        $roles = $user->roles()
            ->pluck('name')
            ->toArray();

        ActivityLogger::log(
            action: 'users.force_delete',
            description: 'User permanently deleted: ' . $user->name,
            category: 'security',
            severity: 'danger',
            icon: 'heroicon-o-exclamation-triangle',
            module: 'core',
            context: [
                'email' => $user->email,
                'roles' => $roles,
            ]
        );
    }
}