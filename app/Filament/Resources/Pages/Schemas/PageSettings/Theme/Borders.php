<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Theme;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class Borders
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | BORDER CORE
            |--------------------------------------------------------------------------
            */

            Section::make('Border Core')
                ->description(
                    'Define the default border appearance used across the public page.'
                )
                ->icon('heroicon-o-square-2-stack')
                ->schema([

                    ColorPicker::make('settings.theme.borders.color')
                        ->label('Border Color')
                        ->helperText(
                            'Default border color for page elements.'
                        )
                        ->default('#e2e8f0')
                        ->hexColor(),

                    Select::make('settings.theme.borders.width')
                        ->label('Border Width')
                        ->helperText(
                            'Default border thickness.'
                        )
                        ->options([
                            '0px' => 'None',
                            '1px' => '1px',
                            '2px' => '2px',
                            '3px' => '3px',
                            '4px' => '4px',
                        ])
                        ->default('1px')
                        ->native(false),

                ])
                ->columns(2),


            /*
            |--------------------------------------------------------------------------
            | BORDER RADIUS
            |--------------------------------------------------------------------------
            */

            Section::make('Border Radius')
                ->description(
                    'Control the default corner radius used by UI elements.'
                )
                ->icon('heroicon-o-square-3-stack-3d')
                ->schema([

                    Select::make('settings.theme.borders.radius')
                        ->label('Default Radius')
                        ->helperText(
                            'Default corner radius for general page elements.'
                        )
                        ->options([
                            '0px' => 'None',
                            '0.125rem' => 'Extra Small',
                            '0.25rem' => 'Small',
                            '0.375rem' => 'Medium',
                            '0.5rem' => 'Large',
                            '0.75rem' => 'Extra Large',
                            '1rem' => '2XL',
                            '1.5rem' => '3XL',
                            '9999px' => 'Full',
                        ])
                        ->default('0.5rem')
                        ->native(false),

                    Select::make('settings.theme.borders.card_radius')
                        ->label('Card Radius')
                        ->helperText(
                            'Corner radius applied to cards and panels.'
                        )
                        ->options([
                            '0px' => 'None',
                            '0.25rem' => 'Small',
                            '0.375rem' => 'Medium',
                            '0.5rem' => 'Large',
                            '0.75rem' => 'Extra Large',
                            '1rem' => '2XL',
                            '1.5rem' => '3XL',
                        ])
                        ->default('0.75rem')
                        ->native(false),

                    Select::make('settings.theme.borders.button_radius')
                        ->label('Button Radius')
                        ->helperText(
                            'Corner radius applied to buttons and action controls.'
                        )
                        ->options([
                            '0px' => 'None',
                            '0.25rem' => 'Small',
                            '0.375rem' => 'Medium',
                            '0.5rem' => 'Large',
                            '0.75rem' => 'Extra Large',
                            '9999px' => 'Pill',
                        ])
                        ->default('0.5rem')
                        ->native(false),

                    Select::make('settings.theme.borders.input_radius')
                        ->label('Input Radius')
                        ->helperText(
                            'Corner radius applied to form inputs and fields.'
                        )
                        ->options([
                            '0px' => 'None',
                            '0.25rem' => 'Small',
                            '0.375rem' => 'Medium',
                            '0.5rem' => 'Large',
                            '0.75rem' => 'Extra Large',
                            '1rem' => '2XL',
                        ])
                        ->default('0.5rem')
                        ->native(false),

                ])
                ->columns(2),

        ];
    }
}