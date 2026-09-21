<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Responsive;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class Breakpoints
{
    public static function schema(): array
    {
        return [

            Section::make('Responsive Breakpoints')
                ->description(
                    'Define the screen width ranges used by the responsive layout system.'
                )
                ->schema([

                    TextInput::make('settings.responsive.breakpoints.mobile_max')
                        ->label('Mobile Maximum Width')
                        ->numeric()
                        ->minValue(320)
                        ->maxValue(767)
                        ->default(767)
                        ->suffix('px')
                        ->helperText(
                            'Maximum screen width considered as mobile.'
                        ),

                    TextInput::make('settings.responsive.breakpoints.tablet_min')
                        ->label('Tablet Minimum Width')
                        ->numeric()
                        ->minValue(768)
                        ->maxValue(1023)
                        ->default(768)
                        ->suffix('px')
                        ->helperText(
                            'Minimum screen width considered as tablet.'
                        ),

                    TextInput::make('settings.responsive.breakpoints.tablet_max')
                        ->label('Tablet Maximum Width')
                        ->numeric()
                        ->minValue(769)
                        ->maxValue(1439)
                        ->default(1023)
                        ->suffix('px')
                        ->helperText(
                            'Maximum screen width considered as tablet.'
                        ),

                    TextInput::make('settings.responsive.breakpoints.desktop_min')
                        ->label('Desktop Minimum Width')
                        ->numeric()
                        ->minValue(1024)
                        ->maxValue(2560)
                        ->default(1024)
                        ->suffix('px')
                        ->helperText(
                            'Minimum screen width considered as desktop.'
                        ),

                ])
                ->columns(2),

        ];
    }
}
