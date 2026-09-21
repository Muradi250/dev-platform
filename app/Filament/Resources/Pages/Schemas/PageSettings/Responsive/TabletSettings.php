<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Responsive;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class TabletSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Tablet Layout')
                ->description(
                    'Configure the page layout and spacing specifically for tablet devices.'
                )
                ->schema([

                    Select::make('settings.responsive.tablet_container')
                        ->label('Container Width')
                        ->options([
                            'full' => 'Full Width',
                            'contained' => 'Contained',
                            'wide' => 'Wide',
                            'narrow' => 'Narrow',
                        ])
                        ->default('contained')
                        ->native(false)
                        ->helperText(
                            'Controls the main content width on tablet devices.'
                        ),

                    TextInput::make('settings.responsive.tablet_horizontal_padding')
                        ->label('Horizontal Padding')
                        ->placeholder('24')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(150)
                        ->default(24)
                        ->suffix('px')
                        ->helperText(
                            'Horizontal spacing between the page content and the screen edges.'
                        ),

                    TextInput::make('settings.responsive.tablet_vertical_spacing')
                        ->label('Vertical Spacing')
                        ->placeholder('24')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(250)
                        ->default(24)
                        ->suffix('px')
                        ->helperText(
                            'Default vertical spacing between tablet page sections.'
                        ),

                    Select::make('settings.responsive.tablet_font_scale')
                        ->label('Font Scale')
                        ->options([
                            '0.9' => '90%',
                            '0.95' => '95%',
                            '1' => '100%',
                            '1.05' => '105%',
                            '1.1' => '110%',
                        ])
                        ->default('1')
                        ->native(false)
                        ->helperText(
                            'Adjust the overall typography scale for tablet devices.'
                        ),

                    Select::make('settings.responsive.tablet_alignment')
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
                            'Controls the default horizontal alignment of tablet content.'
                        ),

                    Select::make('settings.responsive.tablet_navigation')
                        ->label('Navigation Behavior')
                        ->options([
                            'drawer' => 'Drawer',
                            'dropdown' => 'Dropdown',
                            'horizontal' => 'Horizontal',
                            'auto' => 'Automatic',
                        ])
                        ->default('auto')
                        ->native(false)
                        ->helperText(
                            'Controls how the primary navigation behaves on tablet devices.'
                        ),

                ])
                ->columns(2),

        ];
    }
}
