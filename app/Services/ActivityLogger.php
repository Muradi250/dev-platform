<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description = null,
        $model = null,
        array $context = [],
        ?string $category = null,
        ?string $severity = 'info',
        ?string $icon = null,
        ?string $module = null
    ): void {

        $userId = Auth::id();

        // جلوگیری از spam log
        $lastLog = ActivityLog::where('user_id', $userId)
            ->where('action', $action)
            ->latest()
            ->first();

        if ($lastLog && $lastLog->created_at->diffInSeconds(now()) < 2) {
            return;
        }

        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,

            'category' => $category,
            'severity' => $severity,
            'icon' => $icon,
            'module' => $module,

            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,

            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),

            'context' => $context,
        ]);
    }
}