<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Layout;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

class SpacingSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Content Spacing
            |--------------------------------------------------------------------------
            */

            Section::make('Content Spacing')
                ->description(
                    'Control the vertical spacing around the main page content.'
                )
                ->schema([

                    Select::make('settings.layout.spacing.content')
                        ->label('Content Spacing')
                        ->options([
                            '0' => 'None',
                            '1' => 'Extra Small',
                            '2' => 'Small',
                            '3' => 'Medium Small',
                            '4' => 'Medium',
                            '5' => 'Medium Large',
                            '6' => 'Large',
                            '8' => 'Extra Large',
                            '10' => '2X Large',
                            '12' => '3X Large',
                            '16' => '4X Large',
                        ])
                        ->default('8')
                        ->native(false),

                ])
                ->columns(1),

        ];
    }
}