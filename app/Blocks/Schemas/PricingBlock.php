<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;


class PricingBlock extends BaseBlock
{

    public static function schema(): array
    {

        return array_merge([


            /*
            |--------------------------------------------------------------------------
            | Pricing Header
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.badge')

                ->label('Pricing Badge')

                ->placeholder('Simple Pricing'),



            TextInput::make('data.title')

                ->label('Pricing Title')

                ->default('Choose Your Plan')

                ->maxLength(255),



            Textarea::make('data.description')

                ->label('Description')

                ->rows(4),



            TextInput::make('data.currency')

                ->label('Currency')

                ->default('$')

                ->maxLength(10),




            /*
            |--------------------------------------------------------------------------
            | Pricing Plans
            |--------------------------------------------------------------------------
            */


            Repeater::make('data.plans')

                ->label('Pricing Plans')


                ->schema([



                    TextInput::make('name')

                        ->label('Plan Name')

                        ->required(),





                    TextInput::make('badge')

                        ->label('Plan Badge')

                        ->placeholder('Most Popular'),





                    Textarea::make('description')

                        ->label('Plan Description')

                        ->rows(3),





                    TextInput::make('price')

                        ->label('Price')

                        ->required(),





                    TextInput::make('old_price')

                        ->label('Old Price')

                        ->placeholder('79'),






                    TextInput::make('period')

                        ->label('Billing Period')

                        ->default('/month'),





                    Select::make('theme')

                        ->label('Card Theme')

                        ->options([

                            'blue'=>'Blue',

                            'purple'=>'Purple',

                            'green'=>'Green',

                            'dark'=>'Dark',

                        ])

                        ->default('blue'),





                    Toggle::make('featured')

                        ->label('Featured Plan')

                        ->default(false),





                    /*
                    |--------------------------------------------------------------------------
                    | Features
                    |--------------------------------------------------------------------------
                    */


                    Repeater::make('features')

                        ->label('Features')


                        ->schema([



                            TextInput::make('feature')

                                ->label('Feature Text')

                                ->required(),




                            Toggle::make('included')

                                ->label('Included')

                                ->default(true),



                        ])


                        ->defaultItems(3)

                        ->collapsible()

                        ->reorderable(),







                    TextInput::make('button_text')

                        ->label('Button Text')

                        ->default('Get Started'),






                    TextInput::make('button_url')

                        ->label('Button URL')

                        ->default('/register'),





                ])


                ->columns(2)


                ->defaultItems(3)


                ->minItems(1)


                ->collapsible()


                ->reorderable(),





        ],


        self::commonSettings()


        );

    }

}