<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Header;
use App\Filament\Resources\Pages\Schemas\PageSettings\Header\HeaderVisibility;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class HeaderVisibility
{
    public static function schema(): array
    {
        return [
            Section::make('Header Visibility')
                ->schema([
                    Toggle::make('settings.header.visibility.desktop')
                        ->label('Show on Desktop')
                        ->default(true),

                    Toggle::make('settings.header.visibility.tablet')
                        ->label('Show on Tablet')
                        ->default(true),

                    Toggle::make('settings.header.visibility.mobile')
                        ->label('Show on Mobile')
                        ->default(true),
                ])
                ->columns(3),
        ];
    }
}