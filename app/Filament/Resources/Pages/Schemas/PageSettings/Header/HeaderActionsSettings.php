<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class HeaderActionsSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | HEADER ACTIONS
            |--------------------------------------------------------------------------
            |
            | Optional action displayed inside the Page Builder Header.
            | This section is independent from the public site navigation.
            |
            */

            Section::make('Header Actions')
                ->description('Configure an optional action button displayed in the header.')
                ->schema([

                    /*
                    |--------------------------------------------------------------------------
                    | ENABLE ACTION
                    |--------------------------------------------------------------------------
                    */

                    Toggle::make('settings.header.actions.enabled')
                        ->label('Show Action')
                        ->default(false)
                        ->live(),

                    /*
                    |--------------------------------------------------------------------------
                    | ACTION STYLE
                    |--------------------------------------------------------------------------
                    */

                    Select::make('settings.header.actions.style')
                        ->label('Action Style')
                        ->options([
                            'primary' => 'Primary',
                            'secondary' => 'Secondary',
                            'outline' => 'Outline',
                            'ghost' => 'Ghost',
                        ])
                        ->default('primary')
                        ->native(false),

                    /*
                    |--------------------------------------------------------------------------
                    | ACTION TEXT
                    |--------------------------------------------------------------------------
                    */

                    TextInput::make('settings.header.actions.text')
                        ->label('Action Text')
                        ->placeholder('Get Started')
                        ->maxLength(100),

                    /*
                    |--------------------------------------------------------------------------
                    | ACTION URL
                    |--------------------------------------------------------------------------
                    */

                    TextInput::make('settings.header.actions.url')
                        ->label('Action URL')
                        ->placeholder('/register')
                        ->maxLength(255),

                ])
                ->columns(2),
        ];
    }
}