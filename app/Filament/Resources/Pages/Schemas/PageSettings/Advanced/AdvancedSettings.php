<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Advanced;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class AdvancedSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Advanced Page Settings')
                ->schema([
                    TextInput::make('settings.advanced.css_class')
                        ->label('Custom CSS Class')
                        ->helperText('Optional CSS class applied to the page container.')
                        ->maxLength(255),

                    TextInput::make('settings.advanced.html_id')
                        ->label('Custom HTML ID')
                        ->helperText('Optional HTML ID for the page container.')
                        ->maxLength(255),
                ])
                ->columns(2),
        ];
    }
}