<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Responsive;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class DesktopSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Desktop Layout')
                ->description(
                    'Configure the page layout, width, spacing, and navigation specifically for desktop devices.'
                )
                ->schema([

                    Select::make('settings.responsive.desktop_container')
                        ->label('Container Width')
                        ->options([
                            'full' => 'Full Width',
                            'contained' => 'Contained',
                            'wide' => 'Wide',
                            'narrow' => 'Narrow',
                        ])
                        ->default('wide')
                        ->native(false)
                        ->helperText(
                            'Controls the main content width on desktop devices.'
                        ),

                    TextInput::make('settings.responsive.desktop_max_width')
                        ->label('Maximum Content Width')
                        ->placeholder('1440')
                        ->numeric()
                        ->minValue(800)
                        ->maxValue(3000)
                        ->default(1440)
                        ->suffix('px')
                        ->helperText(
                            'Maximum width of the main page content on large screens.'
                        ),

                    TextInput::make('settings.responsive.desktop_horizontal_padding')
                        ->label('Horizontal Padding')
                        ->placeholder('32')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(200)
                        ->default(32)
                        ->suffix('px')
                        ->helperText(
                            'Horizontal spacing between the content and the screen edges.'
                        ),

                    TextInput::make('settings.responsive.desktop_vertical_spacing')
                        ->label('Vertical Spacing')
                        ->placeholder('32')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(300)
                        ->default(32)
                        ->suffix('px')
                        ->helperText(
                            'Default vertical spacing between desktop page sections.'
                        ),

                    Select::make('settings.responsive.desktop_font_scale')
                        ->label('Font Scale')
                        ->options([
                            '0.9' => '90%',
                            '0.95' => '95%',
                            '1' => '100%',
                            '1.05' => '105%',
                            '1.1' => '110%',
                            '1.15' => '115%',
                        ])
                        ->default('1')
                        ->native(false)
                        ->helperText(
                            'Adjust the overall typography scale for desktop devices.'
                        ),

                    Select::make('settings.responsive.desktop_alignment')
                        ->label('Content Alignment')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                            'auto' => 'Automatic',
                        ])
                        ->default('auto')
                        ->native(false)
                        ->helperText(
                            'Controls the default horizontal alignment of desktop content.'
                        ),

                    Select::make('settings.responsive.desktop_navigation')
                        ->label('Navigation Behavior')
                        ->options([
                            'horizontal' => 'Horizontal',
                            'dropdown' => 'Dropdown',
                            'mega_menu' => 'Mega Menu',
                            'auto' => 'Automatic',
                        ])
                        ->default('horizontal')
                        ->native(false)
                        ->helperText(
                            'Controls how the primary navigation behaves on desktop devices.'
                        ),

                ])
                ->columns(2),

        ];
    }
}
