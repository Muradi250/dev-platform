<?php
namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemStats extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('All registered users')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Organizations', Organization::count())
                ->description('Registered organizations')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('info'),

            Stat::make('Employees', Employee::count())
                ->description('Registered employees')
                ->descriptionIcon('heroicon-o-identification')
                ->color('success'),

            Stat::make(
                'Activity Today',
                ActivityLog::whereDate('created_at', Carbon::today())->count()
            )
                ->description('Recorded events today')
                ->descriptionIcon('heroicon-o-bolt')
                ->color('warning'),
        ];
    }
}
