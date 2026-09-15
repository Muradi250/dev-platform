<?php

namespace App\Blocks\Schemas;


/*
|--------------------------------------------------------------------------
| Cards Block Schema
|--------------------------------------------------------------------------
|
| ساخت کارت‌های محتوایی در Page Builder
|
| کاربرد:
|
| - Services
| - Products
| - Modules
| - Features Preview
|
|--------------------------------------------------------------------------
*/


use App\Blocks\BaseBlock;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;



class CardsBlock extends BaseBlock
{


    /*
    |--------------------------------------------------------------------------
    | Schema
    |--------------------------------------------------------------------------
    */


    public static function schema(): array
    {


        return array_merge([




            /*
            |--------------------------------------------------------------------------
            | Section Title
            |--------------------------------------------------------------------------
            */


            TextInput::make(
                'data.title'
            )

                ->label(
                    'Section Title'
                )

                ->maxLength(255)

                ->columnSpanFull(),





            /*
            |--------------------------------------------------------------------------
            | Section Description
            |--------------------------------------------------------------------------
            */


            Textarea::make(
                'data.description'
            )

                ->label(
                    'Section Description'
                )

                ->rows(5)

                ->columnSpanFull(),






            /*
            |--------------------------------------------------------------------------
            | Cards Repeater
            |--------------------------------------------------------------------------
            |
            | هر Card:
            |
            | icon
            | title
            | description
            | button
            |
            |--------------------------------------------------------------------------
            */


            Repeater::make(
                'data.cards'
            )

                ->label(
                    'Cards'
                )


                ->schema([




                    TextInput::make(
                        'icon'
                    )

                        ->label(
                            'Icon'
                        )

                        ->maxLength(100),





                    TextInput::make(
                        'title'
                    )

                        ->label(
                            'Card Title'
                        )

                        ->required()

                        ->maxLength(255),





                    Textarea::make(
                        'description'
                    )

                        ->label(
                            'Description'
                        )

                        ->rows(4)

                        ->columnSpanFull(),





                    TextInput::make(
                        'button_text'
                    )

                        ->label(
                            'Button Text'
                        ),





                    TextInput::make(
                        'button_url'
                    )

                        ->label(
                            'Button URL'
                        ),




                ])

                ->columns(2)

                ->defaultItems(3)

                ->minItems(1)

                ->collapsible()

                ->reorderable(),




        ],



        /*
        |--------------------------------------------------------------------------
        | Common Settings
        |--------------------------------------------------------------------------
        */


        self::commonSettings()



        );


    }


}