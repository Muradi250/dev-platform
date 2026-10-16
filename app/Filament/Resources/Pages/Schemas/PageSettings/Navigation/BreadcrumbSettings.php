<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Navigation;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class BreadcrumbSettings
{
    public static function schema(): array
    {
        return [
            Section::make('Breadcrumb')
                ->schema([
                    Toggle::make('settings.breadcrumb.enabled')
                        ->label('Show Breadcrumb')
                        ->default(true),
                ]),
        ];
    }
}