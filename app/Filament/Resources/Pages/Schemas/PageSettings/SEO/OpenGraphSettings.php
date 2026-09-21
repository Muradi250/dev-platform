<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\SEO;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class OpenGraphSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Open Graph')
                ->icon('heroicon-o-share')
                ->description(
                    'Control how this page appears when shared on social networks and messaging platforms.'
                )
                ->schema([

                    TextInput::make('settings.og_title')
                        ->label('Social Title')
                        ->placeholder('Title shown when the page is shared')
                        ->maxLength(100),

                    TextInput::make('settings.og_description')
                        ->label('Social Description')
                        ->placeholder('Description shown when the page is shared')
                        ->maxLength(200),

                    TextInput::make('settings.og_image')
                        ->label('Social Image URL')
                        ->placeholder('https://example.com/images/social.jpg')
                        ->url()
                        ->helperText(
                            'Recommended Open Graph image size: 1200 × 630 pixels.'
                        ),

                    TextInput::make('settings.og_url')
                        ->label('Open Graph URL')
                        ->placeholder('https://example.com/page')
                        ->url(),

                    Select::make('settings.og_type')
                        ->label('Content Type')
                        ->options([
                            'website' => 'Website',
                            'article' => 'Article',
                            'profile' => 'Profile',
                            'product' => 'Product',
                        ])
                        ->default('website')
                        ->native(false),

                    TextInput::make('settings.og_site_name')
                        ->label('Site Name')
                        ->placeholder('Your website name')
                        ->maxLength(100),

                    TextInput::make('settings.og_locale')
                        ->label('Locale')
                        ->placeholder('en_US')
                        ->maxLength(20)
                        ->helperText(
                            'Example: en_US, fa_IR, or ps_AF.'
                        ),

                ])
                ->columns(1),

        ];
    }
}
