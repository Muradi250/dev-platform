<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class FooterItems
{
    public static function schema(): array
    {
        return [

            Section::make('Footer Items')
                ->description('Manage footer columns, links and icons.')
                ->schema([

                    Repeater::make('settings.footer.items')
                        ->label('Footer Columns')
                        ->schema([

                            TextInput::make('title')
                                ->label('Column Title')
                                ->required()
                                ->maxLength(100),

                            Repeater::make('links')
                                ->label('Column Links')
                                ->schema([

                                    TextInput::make('label')
                                        ->label('Link Label')
                                        ->required()
                                        ->maxLength(100),

                                    Select::make('icon')
                                        ->label('Link Icon')
                                        ->options([
                                            'home' => 'Home',
                                            'about' => 'About',
                                            'user' => 'User',
                                            'contact' => 'Contact',
                                            'phone' => 'Phone',
                                            'mail' => 'Email',
                                            'location' => 'Location',
                                            'services' => 'Services',
                                            'book' => 'Book / Courses',
                                            'document' => 'Document',
                                            'calendar' => 'Calendar',
                                            'clock' => 'Clock',
                                            'lock' => 'Privacy / Security',
                                            'arrow' => 'Arrow',
                                        ])
                                        ->searchable()
                                        ->native(false)
                                        ->default('arrow'),

                                    TextInput::make('url')
                                        ->label('URL')
                                        ->required()
                                        ->maxLength(500),

                                    Toggle::make('new_tab')
                                        ->label('Open in New Tab')
                                        ->default(false),

                                    Toggle::make('active')
                                        ->label('Active')
                                        ->default(true),

                                ])
                                ->defaultItems(0)
                                ->addActionLabel('Add Link')
                                ->columns(2)
                                ->collapsible()
                                ->cloneable()
                                ->reorderable()
                                ->itemLabel(
                                    fn (array $state): ?string =>
                                        $state['label'] ?? null
                                ),

                        ])
                        ->defaultItems(0)
                        ->addActionLabel('Add Footer Column')
                        ->collapsible()
                        ->cloneable()
                        ->reorderable()
                        ->itemLabel(
                            fn (array $state): ?string =>
                                $state['title'] ?? null
                        ),

                ])
                ->columns(1),

        ];
    }
}
