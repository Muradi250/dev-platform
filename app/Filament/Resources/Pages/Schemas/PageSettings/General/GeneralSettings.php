<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\General;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class GeneralSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Page Identity')
                ->schema([
                    TextInput::make('title')
                        ->label('Page Title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            function ($state, callable $set): void {
                                $set('slug', Str::slug($state));
                            }
                        ),

                    TextInput::make('slug')
                        ->label('URL Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(
                            table: 'pages',
                            column: 'slug',
                            ignoreRecord: true
                        ),

                    Select::make('locale')
                        ->label('Language')
                        ->options([
                            'en' => 'English',
                            'fa' => 'فارسی',
                            'ps' => 'پښتو',
                        ])
                        ->default('en')
                        ->required()
                        ->native(false),
                ])
                ->columns(2),
        ];
    }
}