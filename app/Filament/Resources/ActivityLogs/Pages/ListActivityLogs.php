<?php

namespace App\Filament\Resources\ActivityLogs\Pages;

use App\Filament\Resources\ActivityLogs\ActivityLogResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Activities')
                ->icon('heroicon-m-list-bullet'),

            'security' => Tab::make('Security & Authentication')
                ->icon('heroicon-m-shield-check')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $query->where(
                        function (Builder $query): void {
                            $query
                                ->where('category', 'security')
                                ->orWhere('module', 'auth')
                                ->orWhere('action', 'like', 'auth.%')
                                ->orWhere('action', 'like', 'security.%');
                        }
                    )
                ),

            'users' => Tab::make('Users & Access')
                ->icon('heroicon-m-users')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $query->where(
                        function (Builder $query): void {
                            $query
                                ->whereIn('category', ['users', 'access'])
                                ->orWhere('action', 'like', 'users.%')
                                ->orWhere('action', 'like', 'roles.%')
                                ->orWhere('action', 'like', 'permissions.%');
                        }
                    )
                ),

            'organization' => Tab::make('Organization Activity')
                ->icon('heroicon-m-building-office-2')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $query->where(
                        function (Builder $query): void {
                            $query
                                ->where('category', 'organization')
                                ->orWhere('module', 'organization')
                                ->orWhere('action', 'like', 'organization.%')
                                ->orWhere('action', 'like', 'organizations.%')
                                ->orWhere('action', 'like', 'organizational_units.%')
                                ->orWhere('action', 'like', 'memberships.%')
                                ->orWhere('action', 'like', 'employees.%');
                        }
                    )
                ),

            'modules' => Tab::make('Module Activity')
                ->icon('heroicon-m-cube')
                ->modifyQueryUsing(
                    fn (Builder $query): Builder => $query
                        ->whereNotNull('module')
                        ->whereNotIn('module', [
                            'auth',
                            'core',
                            'organization',
                        ])
                ),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }
}