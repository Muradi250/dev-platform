<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        ?string $description = null,
        ?Model $model = null,
        array $context = [],
        ?string $category = null,
        ?string $severity = 'info',
        ?string $icon = null,
        ?string $module = null,
        ?int $actorId = null,
    ): void {
        $prefix = strtolower((string) strtok($action, '.'));

        $category ??= match ($prefix) {
            'auth', 'security' => 'security',
            'users' => 'users',
            'roles', 'permissions' => 'access',
            'organization',
            'organizations',
            'organizational_units',
            'memberships',
            'employees' => 'organization',
            default => 'system',
        };

        $module ??= match ($prefix) {
            'auth' => 'auth',
            'users', 'roles', 'permissions' => 'core',
            'organization',
            'organizations',
            'organizational_units',
            'memberships',
            'employees' => 'organization',
            default => $prefix !== '' ? $prefix : 'core',
        };

        ActivityLog::create([
            'user_id' => $actorId ?? Auth::id(),
            'action' => $action,
            'description' => $description,

            'category' => $category,
            'severity' => $severity,
            'icon' => $icon,
            'module' => $module,

            'model_type' => $model?->getMorphClass(),
            'model_id' => $model?->getKey(),

            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),

            'context' => $context,
        ]);
    }
}