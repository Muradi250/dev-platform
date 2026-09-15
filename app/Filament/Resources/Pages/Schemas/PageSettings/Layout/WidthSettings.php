<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Layout;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class WidthSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Content Width
            |--------------------------------------------------------------------------
            */

            Section::make('Content Width')
                ->description(
                    'Control the maximum width of the main page content.'
                )
                ->schema([

                    Select::make('settings.layout.width.max_width')
                        ->label('Maximum Width')
                        ->options([
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                            'xl' => 'Extra Large',
                            '2xl' => '2X Large',
                            '3xl' => '3X Large',
                            '4xl' => '4X Large',
                            '5xl' => '5X Large',
                            '6xl' => '6X Large',
                            '7xl' => '7X Large',
                            'full' => 'Full Width',
                        ])
                        ->default('7xl')
                        ->native(false),

                ])
                ->columns(1),

        ];
    }
}