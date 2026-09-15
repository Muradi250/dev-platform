<?php

namespace App\Blocks\Schemas;


use App\Blocks\BaseBlock;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;



class TextBlock extends BaseBlock
{


    public static function schema(): array
    {


        return array_merge([



            TextInput::make(
                'data.badge'
            )

                ->label(
                    __('blocks.text.badge')
                )

                ->maxLength(100),





            TextInput::make(
                'data.heading'
            )

                ->label(
                    __('blocks.text.heading')
                )

                ->required()

                ->maxLength(255)

                ->columnSpanFull(),






            Textarea::make(
                'data.content'
            )

                ->label(
                    __('blocks.text.content')
                )

                ->rows(8)

                ->required()

                ->columnSpanFull(),






            TextInput::make(
                'data.button_text'
            )

                ->label(
                    __('blocks.text.button_text')
                ),





            TextInput::make(
                'data.button_url'
            )

                ->label(
                    __('blocks.text.button_url')
                ),







            Select::make(
                'data.alignment'
            )

                ->label(
                    __('blocks.text.alignment')
                )

                ->options([

                    'left'=>__('blocks.text.left'),

                    'center'=>__('blocks.text.center'),

                    'right'=>__('blocks.text.right'),

                ])

                ->default('center'),






            Select::make(
                'data.style'
            )

                ->label(
                    __('blocks.text.style')
                )

                ->options([

                    'default'=>__('blocks.text.default'),

                    'card'=>__('blocks.text.card'),

                    'glass'=>__('blocks.text.glass'),

                    'dark'=>__('blocks.text.dark'),

                    'gradient'=>__('blocks.text.gradient'),

                ])

                ->default('default'),




        ],



        self::commonSettings()



        );


    }


}