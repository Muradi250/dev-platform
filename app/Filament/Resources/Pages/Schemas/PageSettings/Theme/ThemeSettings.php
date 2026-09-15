<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class ThemeSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | THEME MODE
            |--------------------------------------------------------------------------
            */

            Section::make('Theme Mode')
                ->description(
                    'Define the overall color mode used by the public page.'
                )
                ->icon('heroicon-o-moon')
                ->schema([

                    Select::make('settings.theme.mode')
                        ->label('Theme Mode')
                        ->helperText(
                            'Choose Light, Dark, or System to control the page color mode.'
                        )
                        ->options([
                            'light' => 'Light',
                            'dark' => 'Dark',
                            'auto' => 'System',
                        ])
                        ->default('light')
                        ->native(false)
                        ->required(),

                ])
                ->columns(1),


            /*
            |--------------------------------------------------------------------------
            | COLORS
            |--------------------------------------------------------------------------
            */

            ...Colors::schema(),


            /*
            |--------------------------------------------------------------------------
            | BACKGROUNDS
            |--------------------------------------------------------------------------
            */

            ...Backgrounds::schema(),


            /*
            |--------------------------------------------------------------------------
            | TYPOGRAPHY
            |--------------------------------------------------------------------------
            */

            ...Typography::schema(),


            /*
            |--------------------------------------------------------------------------
            | BORDERS
            |--------------------------------------------------------------------------
            */

            ...Borders::schema(),


            /*
            |--------------------------------------------------------------------------
            | SHADOWS
            |--------------------------------------------------------------------------
            */

            ...Shadows::schema(),

        ];
    }
}