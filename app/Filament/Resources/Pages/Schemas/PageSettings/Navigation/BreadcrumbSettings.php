<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Navigation;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class NavigationSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Primary Navigation')
                ->schema([
                    Toggle::make('settings.navigation.primary.enabled')
                        ->label('Enable Primary Navigation')
                        ->default(true),

                    TextInput::make('settings.navigation.primary.title')
                        ->label('Navigation Title')
                        ->maxLength(100),
                ])
                ->columns(2),

            Section::make('Secondary Navigation')
                ->schema([
                    Toggle::make('settings.secondary_navigation.enabled')
                        ->label('Enable Secondary Navigation')
                        ->default(false),

                    TextInput::make('settings.secondary_navigation.title')
                        ->label('Navigation Title')
                        ->maxLength(100),
                ])
                ->columns(2),

            Section::make('Announcement Bar')
                ->schema([
                    Toggle::make('settings.announcement.enabled')
                        ->label('Enable Announcement Bar')
                        ->default(false),

                    TextInput::make('settings.announcement.text')
                        ->label('Announcement Text')
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Breadcrumb')
                ->schema([
                    Toggle::make('settings.breadcrumb.enabled')
                        ->label('Show Breadcrumb')
                        ->default(true),
                ]),
        ];
    }
}