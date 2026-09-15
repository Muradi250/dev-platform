<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class HeaderAppearance
{
    public static function schema(): array
    {
        return [
            Section::make('Header Appearance')
                ->schema([
                    Select::make('settings.header.appearance.style')
                        ->label('Header Style')
                        ->options([
                            'default' => 'Default',
                            'minimal' => 'Minimal',
                            'transparent' => 'Transparent',
                            'solid' => 'Solid',
                        ])
                        ->default('default')
                        ->native(false),

                    Select::make('settings.header.appearance.width')
                        ->label('Header Width')
                        ->options([
                            'container' => 'Container',
                            'wide' => 'Wide',
                            'full' => 'Full Width',
                        ])
                        ->default('container')
                        ->native(false),

                    TextInput::make('settings.header.appearance.height')
                        ->label('Header Height')
                        ->placeholder('80px')
                        ->maxLength(20),

                    ColorPicker::make('settings.header.appearance.background')
                        ->label('Background Color'),

                    ColorPicker::make('settings.header.appearance.text_color')
                        ->label('Text Color'),
                ])
                ->columns(2),
        ];
    }
}