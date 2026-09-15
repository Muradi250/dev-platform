<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Components\Section;

class Colors
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | BRAND COLORS
            |--------------------------------------------------------------------------
            */

            Section::make('Brand Colors')
                ->description(
                    'Define the primary visual identity and brand colors of the page.'
                )
                ->icon('heroicon-o-swatch')
                ->schema([

                    ColorPicker::make('settings.theme.colors.primary')
                        ->label('Primary Color')
                        ->helperText(
                            'Main brand color used for primary actions, links, buttons, and key interface elements.'
                        )
                        ->default('#4f46e5')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.colors.secondary')
                        ->label('Secondary Color')
                        ->helperText(
                            'Supporting brand color used for secondary actions and visual elements.'
                        )
                        ->default('#6366f1')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.colors.accent')
                        ->label('Accent Color')
                        ->helperText(
                            'Highlight color used for emphasis, decorative elements, and important visual details.'
                        )
                        ->default('#8b5cf6')
                        ->hexColor(),

                ])
                ->columns(3),


            /*
            |--------------------------------------------------------------------------
            | SEMANTIC COLORS
            |--------------------------------------------------------------------------
            */

            Section::make('Semantic Colors')
                ->description(
                    'Define system colors used to communicate status and meaning.'
                )
                ->icon('heroicon-o-information-circle')
                ->schema([

                    ColorPicker::make('settings.theme.colors.success')
                        ->label('Success Color')
                        ->helperText(
                            'Used for successful states, confirmations, and positive feedback.'
                        )
                        ->default('#16a34a')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.colors.warning')
                        ->label('Warning Color')
                        ->helperText(
                            'Used for warnings, attention states, and non-critical notices.'
                        )
                        ->default('#d97706')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.colors.danger')
                        ->label('Danger Color')
                        ->helperText(
                            'Used for errors, destructive actions, and critical warnings.'
                        )
                        ->default('#dc2626')
                        ->hexColor(),

                    ColorPicker::make('settings.theme.colors.info')
                        ->label('Info Color')
                        ->helperText(
                            'Used for informational messages and neutral system feedback.'
                        )
                        ->default('#0284c7')
                        ->hexColor(),

                ])
                ->columns(4),

        ];
    }
}