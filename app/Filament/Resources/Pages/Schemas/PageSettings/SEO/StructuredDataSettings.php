<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;

class StructuredDataSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Structured Data')
                ->icon('heroicon-o-code-bracket-square')
                ->description(
                    'Configure structured data that helps search engines understand the content of this page.'
                )
                ->schema([

                    Select::make('settings.schema_type')
                        ->label('Schema Type')
                        ->options([
                            'WebPage' => 'Web Page',
                            'Article' => 'Article',
                            'BlogPosting' => 'Blog Post',
                            'Organization' => 'Organization',
                            'Person' => 'Person',
                            'Product' => 'Product',
                            'Service' => 'Service',
                            'Event' => 'Event',
                            'FAQPage' => 'FAQ Page',
                            'BreadcrumbList' => 'Breadcrumb',
                            'LocalBusiness' => 'Local Business',
                        ])
                        ->default('WebPage')
                        ->native(false),

                    Textarea::make('settings.schema_description')
                        ->label('Schema Description')
                        ->rows(3)
                        ->maxLength(500)
                        ->placeholder(
                            'Short description of the structured content.'
                        ),

                    KeyValue::make('settings.schema_properties')
                        ->label('Schema Properties')
                        ->keyLabel('Property')
                        ->valueLabel('Value')
                        ->addActionLabel('Add Property')
                        ->helperText(
                            'Add additional Schema.org properties for this page.'
                        ),

                    Textarea::make('settings.schema_custom_json')
                        ->label('Custom JSON-LD')
                        ->rows(10)
                        ->placeholder(
                            '{ "key": "value" }'
                        )
                        ->helperText(
                            'Optional advanced JSON-LD. Use valid JSON only.'
                        ),

                ])
                ->columns(1),

        ];
    }
}
