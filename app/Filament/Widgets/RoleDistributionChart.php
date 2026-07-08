<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class RoleDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Role Distribution';

    protected function getData(): array
    {
        $superAdmin = User::role('super-admin')->count();
        $admin      = User::role('admin')->count();
        $manager    = User::role('manager')->count();
        $user       = User::role('user')->count();

        $total = $superAdmin + $admin + $manager + $user;

        $safeTotal = $total > 0 ? $total : 1;

        return [
            'datasets' => [
                [
                    'data' => [
                        $superAdmin,
                        $admin,
                        $manager,
                        $user,
                    ],

                    // رنگ‌های حرفه‌ای و تمیز
                    'backgroundColor' => [
                        '#6366F1', // super-admin (indigo)
                        '#F59E0B', // admin (amber)
                        '#3B82F6', // manager (blue)
                        '#10B981', // user (green)
                    ],

                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                    'hoverOffset' => 8,
                ],
            ],

            // فقط اسم ساده (نه درصد داخل label)
            'labels' => [
                'Super Admin',
                'Admin',
                'Manager',
                'User',
            ],

            // 🔥 tooltip حرفه‌ای
            'options' => [
                'plugins' => [
                    'tooltip' => [
                        'callbacks' => [
                            'label' => 'function(context) {
                                let value = context.raw;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percent = ((value / total) * 100).toFixed(1);
                                return context.label + ": " + value + " (" + percent + "%)";
                            }',
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getPollingInterval(): ?string
    {
        return '10s';
    }
}