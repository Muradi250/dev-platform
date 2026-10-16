<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActivityFeed;
use App\Filament\Widgets\DashboardModuleCards;
use App\Filament\Widgets\LatestUsers;
use App\Filament\Widgets\RoleDistributionChart;
use App\Filament\Widgets\SystemStats;
use App\Filament\Widgets\UserGrowthChart;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    /**
     * Responsive dashboard layout.
     */
    public function getColumns(): int | array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 2,
            'xl' => 4,
        ];
    }

    /**
     * Keep all existing dashboard widgets.
     */
    public function getWidgets(): array
    {
        return [
            SystemStats::class,
            UserGrowthChart::class,
            RoleDistributionChart::class,
            DashboardModuleCards::class,
            LatestUsers::class,
            ActivityFeed::class,
        ];
    }

    /**
     * Organize dashboard widgets into four colored sections.
     */
    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('System Statistics')
                ->icon('heroicon-o-chart-bar')
                ->iconColor('info')
                ->extraAttributes([
                    'class' => 'border-l-4 border-sky-500',
                ])
                ->divided()
                ->columnSpanFull()
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'xl' => 2,
                    ])->schema(
                        $this->getWidgetsSchemaComponents([
                            SystemStats::class,
                            UserGrowthChart::class,
                        ])
                    ),
                ]),

            Section::make('Roles & Permissions')
                ->icon('heroicon-o-shield-check')
                ->iconColor('primary')
                ->extraAttributes([
                    'class' => 'border-l-4 border-violet-500',
                ])
                ->divided()
                ->columnSpanFull()
                ->schema(
                    $this->getWidgetsSchemaComponents([
                        RoleDistributionChart::class,
                    ])
                ),

            Section::make('System Modules')
                ->icon('heroicon-o-squares-2x2')
                ->iconColor('success')
                ->extraAttributes([
                    'class' => 'border-l-4 border-teal-500',
                ])
                ->divided()
                ->columnSpanFull()
                ->schema(
                    $this->getWidgetsSchemaComponents([
                        DashboardModuleCards::class,
                    ])
                ),

            Section::make('Users & Activity')
                ->icon('heroicon-o-users')
                ->iconColor('warning')
                ->extraAttributes([
                    'class' => 'border-l-4 border-orange-500',
                ])
                ->divided()
                ->columnSpanFull()
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'xl' => 2,
                    ])->schema(
                        $this->getWidgetsSchemaComponents([
                            LatestUsers::class,
                            ActivityFeed::class,
                        ])
                    ),
                ]),
        ]);
    }
}
