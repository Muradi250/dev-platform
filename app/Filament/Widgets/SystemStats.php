<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class SystemStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('New Today', User::whereDate('created_at', Carbon::today())->count())
                ->description('Users registered today')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('success'),

            Stat::make('This Week', User::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count())
                ->description('Users registered this week')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Super Admins', User::role('super-admin')->count())
                ->description('Full system access')
                ->descriptionIcon('heroicon-o-star')
                ->color('danger'),

            Stat::make('Admins', User::role('admin')->count())
                ->description('Admin level users')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('warning'),

            Stat::make('Managers', User::role('manager')->count())
                ->description('Management level users')
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('info'),

            Stat::make('Regular Users', User::role('user')->count())
                ->description('Standard users')
                ->descriptionIcon('heroicon-o-user')
                ->color('gray'),
        ];
    }
}