<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Footer;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class FooterSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | GENERAL FOOTER SETTINGS
            |--------------------------------------------------------------------------
            */

            Section::make('Footer')
                ->description('General footer settings.')
                ->schema([

                    Toggle::make('settings.footer.enabled')
                        ->label('Show Footer')
                        ->default(true),

                    TextInput::make('settings.footer.text')
                        ->label('Footer Text')
                        ->maxLength(255),

                ])
                ->columns(2),

        ];
    }
}
