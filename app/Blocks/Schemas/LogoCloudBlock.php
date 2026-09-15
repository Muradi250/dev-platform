<?php

namespace App\Blocks\Schemas;

/*
|--------------------------------------------------------------------------
| Logo Cloud Block Schema
|--------------------------------------------------------------------------
|
| نمایش لوگوی شرکت‌ها و شرکای تجاری
|
| کاربرد:
|
| - Trusted Companies
| - Partners
| - Integrations
|
|--------------------------------------------------------------------------
*/

use App\Blocks\BaseBlock;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

class LogoCloudBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge(
            [

                TextInput::make(
                    'data.title'
                )
                    ->label(
                        'Section Title'
                    )
                    ->maxLength(255),

                Textarea::make(
                    'data.description'
                )
                    ->label(
                        'Description'
                    )
                    ->rows(4),

                /*
                |--------------------------------------------------------------------------
                | Logos
                |--------------------------------------------------------------------------
                */

                Repeater::make(
                    'data.logos'
                )
                    ->label(
                        'Company Logos'
                    )
                    ->schema([

                        TextInput::make(
                            'name'
                        )
                            ->label(
                                'Company Name'
                            )
                            ->required(),

                        FileUpload::make(
                            'image'
                        )
                            ->label(
                                'Logo'
                            )
                            ->image()
                            ->disk('public')
                            ->directory(
                                'blocks/logos'
                            ),

                        TextInput::make(
                            'url'
                        )
                            ->label(
                                'Website URL'
                            )
                            ->url(),

                    ])
                    ->columns(2)
                    ->defaultItems(5)
                    ->minItems(1)
                    ->collapsible()
                    ->reorderable(),

            ],

            self::commonSettings()
        );
    }
}