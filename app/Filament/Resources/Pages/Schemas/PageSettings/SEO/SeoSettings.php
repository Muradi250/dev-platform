<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SeoSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Search Engine Optimization')
                ->icon('heroicon-o-magnifying-glass')
                ->description(
                    'Configure the primary SEO metadata and canonical settings for this page.'
                )
                ->schema([

                    TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->placeholder('Enter the page title for search engines')
                        ->helperText('Recommended length: 50–60 characters.')
                        ->maxLength(60),

                    TextInput::make('seo_description')
                        ->label('SEO Description')
                        ->placeholder('Enter a concise description of this page')
                        ->helperText('Recommended length: 120–160 characters.')
                        ->maxLength(160),

                    TextInput::make('settings.seo_keywords')
                        ->label('SEO Keywords')
                        ->placeholder('keyword, another keyword, relevant topic')
                        ->helperText('Optional. Separate keywords with commas.')
                        ->maxLength(500),

                    TextInput::make('settings.seo_canonical_url')
                        ->label('Canonical URL')
                        ->placeholder('https://example.com/page')
                        ->url()
                        ->helperText(
                            'Optional. Leave empty to use the page URL automatically.'
                        ),

                ])
                ->columns(1),

        ];
    }
}
