<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class SeoSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Search Engine Optimization')
                ->schema([
                    TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->maxLength(60),

                    Textarea::make('seo_description')
                        ->label('SEO Description')
                        ->rows(4)
                        ->maxLength(160),
                ])
                ->columns(1),
        ];
    }
}