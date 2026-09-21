<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class MetaSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Meta Tags')
                ->icon('heroicon-o-code-bracket')
                ->description(
                    'Configure additional metadata used by browsers, search engines, and web services.'
                )
                ->schema([

                    TextInput::make('settings.meta_author')
                        ->label('Author')
                        ->placeholder('Author or organization name')
                        ->maxLength(150),

                    TextInput::make('settings.meta_application_name')
                        ->label('Application Name')
                        ->placeholder('Website or application name')
                        ->maxLength(150),

                    TextInput::make('settings.meta_theme_color')
                        ->label('Theme Color')
                        ->placeholder('#4f46e5')
                        ->maxLength(20),

                    TextInput::make('settings.meta_referrer')
                        ->label('Referrer Policy')
                        ->placeholder('strict-origin-when-cross-origin')
                        ->maxLength(100),

                    KeyValue::make('settings.meta_custom')
                        ->label('Custom Meta Tags')
                        ->keyLabel('Meta Name')
                        ->valueLabel('Content')
                        ->addActionLabel('Add Meta Tag')
                        ->helperText(
                            'Add custom meta name/content pairs when required.'
                        ),

                ])
                ->columns(1),

        ];
    }
}
