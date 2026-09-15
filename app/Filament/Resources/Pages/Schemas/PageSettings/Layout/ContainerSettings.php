<?php

namespace App\Filament\Resources\Pages\Schemas\PageSettings\Layout;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class ContainerSettings
{
    public static function schema(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Container
            |--------------------------------------------------------------------------
            */

            Section::make('Container')
                ->description(
                    'Control the main content container of the page.'
                )
                ->schema([

                    Toggle::make('settings.layout.container.enabled')
                        ->label('Enable Container')
                        ->helperText(
                            'Wrap the main page content inside a centered container.'
                        )
                        ->default(true),

                    Select::make('settings.layout.container.padding')
                        ->label('Horizontal Padding')
                        ->helperText(
                            'Space between the content and the left and right edges of the container.'
                        )
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
                        ])
                        ->default('6')
                        ->native(false),

                ])
                ->columns(2),

        ];
    }
}
