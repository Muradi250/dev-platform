<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Layout;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class LayoutSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Layout Mode
            |--------------------------------------------------------------------------
            */

            Section::make('Layout')
                ->description(
                    'Choose how the main content of this page is structured and positioned.'
                )
                ->schema([

                    Select::make('settings.layout.mode')
                        ->label('Layout Mode')
                        ->options([
                            'standard' => 'Standard',
                            'wide' => 'Wide',
                            'full_width' => 'Full Width',
                            'sidebar_left' => 'Sidebar Left',
                            'sidebar_right' => 'Sidebar Right',
                        ])
                        ->default('standard')
                        ->native(false),

                ])
                ->columns(1),

        ];
    }
}
