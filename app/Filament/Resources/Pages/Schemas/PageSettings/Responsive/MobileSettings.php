<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Responsive;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class MobileSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Mobile Layout')
                ->description(
                    'Configure the page layout and spacing specifically for mobile devices.'
                )
                ->schema([

                    Select::make('settings.responsive.mobile_container')
                        ->label('Container Width')
                        ->options([
                            'full' => 'Full Width',
                            'contained' => 'Contained',
                            'narrow' => 'Narrow',
                        ])
                        ->default('full')
                        ->native(false)
                        ->helperText(
                            'Controls the main content width on mobile devices.'
                        ),

                    TextInput::make('settings.responsive.mobile_horizontal_padding')
                        ->label('Horizontal Padding')
                        ->placeholder('16')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(16)
                        ->suffix('px')
                        ->helperText(
                            'Horizontal spacing between the page content and the screen edges.'
                        ),

                    TextInput::make('settings.responsive.mobile_vertical_spacing')
                        ->label('Vertical Spacing')
                        ->placeholder('16')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(200)
                        ->default(16)
                        ->suffix('px')
                        ->helperText(
                            'Default vertical spacing between mobile page sections.'
                        ),

                    Select::make('settings.responsive.mobile_font_scale')
                        ->label('Font Scale')
                        ->options([
                            '0.85' => '85%',
                            '0.9' => '90%',
                            '0.95' => '95%',
                            '1' => '100%',
                            '1.05' => '105%',
                            '1.1' => '110%',
                        ])
                        ->default('1')
                        ->native(false)
                        ->helperText(
                            'Adjust the overall typography scale for mobile devices.'
                        ),

                    Select::make('settings.responsive.mobile_alignment')
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
                            'Controls the default horizontal alignment of mobile content.'
                        ),

                    Select::make('settings.responsive.mobile_navigation')
                        ->label('Navigation Behavior')
                        ->options([
                            'drawer' => 'Drawer',
                            'dropdown' => 'Dropdown',
                            'stacked' => 'Stacked',
                            'auto' => 'Automatic',
                        ])
                        ->default('drawer')
                        ->native(false)
                        ->helperText(
                            'Controls how the primary navigation behaves on mobile devices.'
                        ),

                ])
                ->columns(2),

        ];
    }
}
