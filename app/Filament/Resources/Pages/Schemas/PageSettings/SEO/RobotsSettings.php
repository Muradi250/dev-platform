<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class RobotsSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Search Engine Robots')
                ->icon('heroicon-o-globe-alt')
                ->description(
                    'Control how search engine crawlers should access and index this page.'
                )
                ->schema([

                    Select::make('settings.robots_index')
                        ->label('Indexing')
                        ->options([
                            'index' => 'Index',
                            'noindex' => 'No Index',
                        ])
                        ->default('index')
                        ->native(false),

                    Select::make('settings.robots_follow')
                        ->label('Link Following')
                        ->options([
                            'follow' => 'Follow',
                            'nofollow' => 'No Follow',
                        ])
                        ->default('follow')
                        ->native(false),

                    Toggle::make('settings.robots_archive')
                        ->label('Allow Search Engine Cache')
                        ->default(true),

                    Toggle::make('settings.robots_snippet')
                        ->label('Allow Search Snippet')
                        ->default(true),

                    Toggle::make('settings.robots_image_index')
                        ->label('Allow Image Indexing')
                        ->default(true),

                ])
                ->columns(1),

        ];
    }
}
