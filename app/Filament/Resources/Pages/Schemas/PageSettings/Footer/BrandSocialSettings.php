<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class BrandSocialSettings
{
    public static function schema(): array
    {
        return [

            Section::make('Brand & Social')
                ->description('Configure the footer logo, brand description and social media links.')
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | BRAND
                    |--------------------------------------------------------------------------
                    */

                    Toggle::make('settings.footer.brand.enabled')
                        ->label('Enable Brand Section')
                        ->default(true)
                        ->live(),

                    FileUpload::make('settings.footer.brand.logo')
                        ->label('Footer Logo')
                        ->image()
                        ->disk('public')
                        ->directory('footer')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->visible(
                            fn ($get): bool =>
                                (bool) $get('settings.footer.brand.enabled')
                        ),

                    TextInput::make('settings.footer.brand.logo_width')
                        ->label('Logo Width')
                        ->numeric()
                        ->default(160)
                        ->suffix('px')
                        ->minValue(1)
                        ->maxValue(1000)
                        ->visible(
                            fn ($get): bool =>
                                (bool) $get('settings.footer.brand.enabled')
                        ),

                    Textarea::make('settings.footer.brand.description')
                        ->label('Brand Description')
                        ->rows(4)
                        ->maxLength(500)
                        ->placeholder(
                            'A short description about your company or platform.'
                        )
                        ->visible(
                            fn ($get): bool =>
                                (bool) $get('settings.footer.brand.enabled')
                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | SOCIAL ENABLE
                    |--------------------------------------------------------------------------
                    */

                    Toggle::make('settings.footer.brand.social.enabled')
                        ->label('Show Social Icons')
                        ->default(true)
                        ->live()
                        ->visible(
                            fn ($get): bool =>
                                (bool) $get('settings.footer.brand.enabled')
                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | SOCIAL ITEMS
                    |--------------------------------------------------------------------------
                    */

                    Repeater::make('settings.footer.brand.social.items')
                        ->label('Social Media Links')
                        ->schema([

                            Select::make('platform')
                                ->label('Platform')
                                ->options([
                                    'facebook' => 'Facebook',
                                    'instagram' => 'Instagram',
                                    'x' => 'X / Twitter',
                                    'linkedin' => 'LinkedIn',
                                    'youtube' => 'YouTube',
                                    'telegram' => 'Telegram',
                                    'whatsapp' => 'WhatsApp',
                                    'tiktok' => 'TikTok',
                                ])
                                ->searchable()
                                ->native(false)
                                ->required(),

                            TextInput::make('url')
                                ->label('URL')
                                ->url()
                                ->required()
                                ->placeholder('https://example.com'),

                            Toggle::make('new_tab')
                                ->label('Open in New Tab')
                                ->default(true),

                            Toggle::make('enabled')
                                ->label('Enabled')
                                ->default(true),

                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->reorderable()
                        ->collapsible()
                        ->cloneable()
                        ->addActionLabel('Add Social Network')
                        ->visible(
                            fn ($get): bool =>
                                (bool) $get('settings.footer.brand.enabled')
                                && (bool) $get('settings.footer.brand.social.enabled')
                        ),

                ])
                ->columns(2),

        ];
    }
}
