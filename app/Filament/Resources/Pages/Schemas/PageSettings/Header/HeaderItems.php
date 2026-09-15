<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class HeaderItems
{
    public static function schema(): array
    {
        return [

            Section::make('Header Items')
                ->description(
                    'Configure the main items displayed inside the Page Builder Header.'
                )
                ->schema([

                    Section::make('Title')
                        ->description(
                            'Configure the title displayed in the center of the header.'
                        )
                        ->schema([

                            Toggle::make('settings.header.items.title')
                                ->label('Show Title')
                                ->default(true)
                                ->live(),

                            Select::make('settings.header.title.source')
                                ->label('Title Source')
                                ->options([
                                    'page' => 'Page Title',
                                    'custom' => 'Custom Title',
                                ])
                                ->default('page')
                                ->native(false)
                                ->live(),

                            TextInput::make('settings.header.title.text')
                                ->label('Custom Title')
                                ->placeholder('Page Title')
                                ->maxLength(150)
                                ->visible(fn ($get) =>
                                    $get('settings.header.title.source') === 'custom'
                                ),

                            Select::make('settings.header.title.font_size')
                                ->label('Font Size')
                                ->options([
                                    'xs' => 'Extra Small',
                                    'sm' => 'Small',
                                    'base' => 'Normal',
                                    'lg' => 'Large',
                                    'xl' => 'Extra Large',
                                    '2xl' => '2X Large',
                                    '3xl' => '3X Large',
                                ])
                                ->default('lg')
                                ->native(false),

                            Select::make('settings.header.title.font_weight')
                                ->label('Font Weight')
                                ->options([
                                    'normal' => 'Normal',
                                    'medium' => 'Medium',
                                    'semibold' => 'Semi Bold',
                                    'bold' => 'Bold',
                                    'extrabold' => 'Extra Bold',
                                ])
                                ->default('bold')
                                ->native(false),

                            ColorPicker::make('settings.header.title.color')
                                ->label('Text Color')
                                ->default('#1e293b'),

                            Select::make('settings.header.title.max_width')
                                ->label('Maximum Width')
                                ->options([
                                    '30' => '30%',
                                    '40' => '40%',
                                    '45' => '45%',
                                    '50' => '50%',
                                    '60' => '60%',
                                    '70' => '70%',
                                ])
                                ->default('45')
                                ->native(false),

                        ])
                        ->columns(2),

                    Section::make('Logo')
                        ->description(
                            'Configure the logo displayed in the header.'
                        )
                        ->schema([

                            Toggle::make('settings.header.items.logo')
                                ->label('Show Logo')
                                ->default(true)
                                ->live(),

                            Select::make('settings.header.logo.type')
                                ->label('Logo Type')
                                ->options([
                                    'text' => 'Text',
                                    'image' => 'Image',
                                    'image_text' => 'Image + Text',
                                ])
                                ->default('text')
                                ->native(false)
                                ->live(),

                            FileUpload::make('settings.header.logo.image')
                                ->label('Logo Image')
                                ->image()
                                ->disk('public')
                                ->directory('page-builder/header')
                                ->visibility('public')
                                ->visible(fn ($get) =>
                                    in_array(
                                        $get('settings.header.logo.type'),
                                        ['image', 'image_text'],
                                        true
                                    )
                                ),

                            TextInput::make('settings.header.logo.text')
                                ->label('Logo Text')
                                ->placeholder('Dev-Platform')
                                ->maxLength(100)
                                ->visible(fn ($get) =>
                                    in_array(
                                        $get('settings.header.logo.type'),
                                        ['text', 'image_text'],
                                        true
                                    )
                                ),

                            TextInput::make('settings.header.logo.url')
                                ->label('Logo Link')
                                ->placeholder('/')
                                ->default('/')
                                ->maxLength(255),

                        ])
                        ->columns(2),

                    Section::make('Social Icons')
                        ->description(
                            'Add and manage social media icons displayed on the right side of the header.'
                        )
                        ->schema([

                            Toggle::make('settings.header.items.social')
                                ->label('Show Social Icons')
                                ->default(false)
                                ->live(),

                            Select::make('settings.header.social.icon_size')
                                ->label('Icon Size')
                                ->options([
                                    'sm' => 'Small',
                                    'md' => 'Medium',
                                    'lg' => 'Large',
                                    'xl' => 'Extra Large',
                                ])
                                ->default('md')
                                ->native(false)
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.social') === true
                                ),

                            ColorPicker::make('settings.header.social.color')
                                ->label('Icon Color')
                                ->default('#475569')
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.social') === true
                                ),

                            ColorPicker::make('settings.header.social.hover_color')
                                ->label('Hover Color')
                                ->default('#2563eb')
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.social') === true
                                ),

                            Toggle::make('settings.header.social.new_tab')
                                ->label('Open Links in New Tab')
                                ->default(true)
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.social') === true
                                ),

                            Repeater::make('settings.header.social.links')
                                ->label('Social Links')
                                ->schema([

                                    Select::make('platform')
                                        ->label('Platform')
                                        ->options([
                                            'facebook' => 'Facebook',
                                            'instagram' => 'Instagram',
                                            'x' => 'X',
                                            'linkedin' => 'LinkedIn',
                                            'youtube' => 'YouTube',
                                            'telegram' => 'Telegram',
                                            'whatsapp' => 'WhatsApp',
                                            'github' => 'GitHub',
                                            'tiktok' => 'TikTok',
                                            'discord' => 'Discord',
                                            'reddit' => 'Reddit',
                                            'behance' => 'Behance',
                                            'dribbble' => 'Dribbble',
                                        ])
                                        ->native(false)
                                        ->required(),

                                    TextInput::make('url')
                                        ->label('Social Link')
                                        ->placeholder('https://...')
                                        ->url()
                                        ->maxLength(500)
                                        ->required(),

                                    Toggle::make('enabled')
                                        ->label('Enabled')
                                        ->default(true),

                                ])
                                ->columns(3)
                                ->defaultItems(0)
                                ->reorderable()
                                ->collapsible()
                                ->cloneable()
                                ->itemLabel(fn (array $state): ?string =>
                                    $state['platform'] ?? 'Social Link'
                                )
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.social') === true
                                ),

                        ])
                        ->columns(2),

                    Section::make('CTA')
                        ->description(
                            'Optional call-to-action displayed inside the header.'
                        )
                        ->schema([

                            Toggle::make('settings.header.items.cta')
                                ->label('Show CTA')
                                ->default(false)
                                ->live(),

                            TextInput::make('settings.header.cta.text')
                                ->label('CTA Text')
                                ->placeholder('Get Started')
                                ->maxLength(100)
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.cta') === true
                                ),

                            TextInput::make('settings.header.cta.url')
                                ->label('CTA Link')
                                ->placeholder('/register')
                                ->maxLength(255)
                                ->visible(fn ($get) =>
                                    $get('settings.header.items.cta') === true
                                ),

                        ])
                        ->columns(2),

                ]),

        ];
    }
}
