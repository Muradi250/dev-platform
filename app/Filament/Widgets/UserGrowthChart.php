<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class UserGrowthChart extends ChartWidget
{
    protected ?string $heading = 'User Growth (Last 7 Days)';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // 7 روز اخیر
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $count = User::whereDate('created_at', $date)->count();

            $labels[] = $date->format('D'); // Mon, Tue...
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $data,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}