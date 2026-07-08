<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\ActivityLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Admins', User::role('admin')->count())
                ->description('Admin users')
                ->icon('heroicon-o-shield-check')
                ->color('warning'),

            Stat::make('Logins', ActivityLog::where('action', 'auth.login')->count())
                ->description('Total login events')
                ->icon('heroicon-o-arrow-right-end-on-rectangle')
                ->color('success'),

            Stat::make('Logouts', ActivityLog::where('action', 'auth.logout')->count())
                ->description('Total logout events')
                ->icon('heroicon-o-arrow-left-start-on-rectangle')
                ->color('danger'),
        ];
    }
}