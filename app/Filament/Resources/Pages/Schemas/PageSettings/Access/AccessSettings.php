<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Access;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class AccessSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Page Access')
                ->schema([
                    Select::make('settings.access.visibility')
                        ->label('Visibility')
                        ->options([
                            'public' => 'Public',
                            'authenticated' => 'Authenticated Users',
                            'private' => 'Private',
                        ])
                        ->default('public')
                        ->native(false),
                ]),
        ];
    }
}