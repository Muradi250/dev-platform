<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class HeaderCoreSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Header')
                ->schema([
                    Toggle::make('settings.header.enabled')
                        ->label('Show Header')
                        ->default(true),
                ]),
        ];
    }
}