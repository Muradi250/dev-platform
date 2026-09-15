<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Responsive;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class ResponsiveSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Responsive Behavior')
                ->schema([
                    Toggle::make('settings.responsive.mobile')
                        ->label('Mobile Optimized')
                        ->default(true),

                    Toggle::make('settings.responsive.tablet')
                        ->label('Tablet Optimized')
                        ->default(true),

                    Toggle::make('settings.responsive.desktop')
                        ->label('Desktop Optimized')
                        ->default(true),
                ])
                ->columns(3),
        ];
    }
}