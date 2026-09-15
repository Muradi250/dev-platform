<?php

namespace App\Blocks\Schemas;


/*
|--------------------------------------------------------------------------
| HTML Block Schema
|--------------------------------------------------------------------------
|
| Block پیشرفته برای HTML سفارشی
|
| کاربرد:
|
| - Custom Components
| - External Widgets
| - Advanced Embed
|
| توجه:
|
| فقط کاربران دارای دسترسی مناسب
| باید بتوانند HTML وارد کنند.
|
|--------------------------------------------------------------------------
*/


use App\Blocks\BaseBlock;


use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;



class HtmlBlock extends BaseBlock
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
            | Custom HTML
            |--------------------------------------------------------------------------
            */


            Textarea::make(
                'data.html'
            )

                ->label(
                    'Custom HTML'
                )

                ->rows(15)

                ->columnSpanFull(),





            /*
            |--------------------------------------------------------------------------
            | CSS Class
            |--------------------------------------------------------------------------
            */


            TextInput::make(
                'data.css_class'
            )

                ->label(
                    'Custom CSS Class'
                )

                ->maxLength(150),





        ],



        self::commonSettings()



        );


    }


}