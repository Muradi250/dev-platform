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
                ->description(
                    'Control responsive behavior for mobile, tablet, and desktop devices.'
                )
                ->schema([

                    Toggle::make('settings.responsive.mobile')
                        ->label('Mobile Optimized')
                        ->helperText(
                            'Enable responsive layout behavior for mobile devices.'
                        )
                        ->default(true),

                    Toggle::make('settings.responsive.tablet')
                        ->label('Tablet Optimized')
                        ->helperText(
                            'Enable responsive layout behavior for tablet devices.'
                        )
                        ->default(true),

                    Toggle::make('settings.responsive.desktop')
                        ->label('Desktop Optimized')
                        ->helperText(
                            'Enable responsive layout behavior for desktop devices.'
                        )
                        ->default(true),

                ])
                ->columns(3),

        ];
    }
}
