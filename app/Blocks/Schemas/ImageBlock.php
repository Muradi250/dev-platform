<?php


namespace App\Blocks\Schemas;


use App\Blocks\BaseBlock;


use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;



class ImageBlock extends BaseBlock
{


    /**
     * Advanced Image Block
     *
     * Features:
     *
     * - Image
     * - SEO Alt
     * - Caption
     * - Link
     * - Style
     * - Hover
     * - Responsive
     *
     */


    public static function schema(): array
    {


        return array_merge([




            /*
            |--------------------------------------------------------------------------
            | Main Image
            |--------------------------------------------------------------------------
            */


            FileUpload::make('data.image')

                ->label('Image')

                ->image()

                ->disk('public')

                ->directory('blocks/images')

                ->visibility('public')

                ->imageEditor()

                ->required(),






            /*
            |--------------------------------------------------------------------------
            | SEO Alt Text
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.alt')

                ->label('Alt Text')

                ->helperText(
                    'Used for SEO and accessibility'
                )

                ->maxLength(255),






            /*
            |--------------------------------------------------------------------------
            | Title
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.title')

                ->label('Image Title')

                ->maxLength(255),






            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */


            Textarea::make('data.description')

                ->label('Description')

                ->rows(4)

                ->columnSpanFull(),






            /*
            |--------------------------------------------------------------------------
            | Caption
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.caption')

                ->label('Caption')

                ->maxLength(255),






            /*
            |--------------------------------------------------------------------------
            | Link
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.link')

                ->label('Image Link')

                ->url(),





            Toggle::make('data.new_tab')

                ->label('Open Link New Tab')

                ->default(false),






            /*
            |--------------------------------------------------------------------------
            | Position
            |--------------------------------------------------------------------------
            */


            Select::make('data.position')

                ->label('Position')

                ->options([

                    'left'=>'Left',

                    'center'=>'Center',

                    'right'=>'Right',

                ])

                ->default('center'),






            /*
            |--------------------------------------------------------------------------
            | Image Style
            |--------------------------------------------------------------------------
            */


            Select::make('data.style')

                ->label('Image Style')

                ->options([

                    'normal'=>'Normal',

                    'card'=>'Card',

                    'circle'=>'Circle',

                    'full'=>'Full Width',

                ])

                ->default('normal'),






            /*
            |--------------------------------------------------------------------------
            | Aspect Ratio
            |--------------------------------------------------------------------------
            */


            Select::make('data.ratio')

                ->label('Aspect Ratio')

                ->options([

                    'auto'=>'Auto',

                    'square'=>'Square',

                    '16/9'=>'16:9',

                    '4/3'=>'4:3',

                    '3/2'=>'3:2',

                ])

                ->default('auto'),






            /*
            |--------------------------------------------------------------------------
            | Radius
            |--------------------------------------------------------------------------
            */


            Select::make('data.radius')

                ->label('Border Radius')

                ->options([

                    'none'=>'None',

                    'small'=>'Small',

                    'medium'=>'Medium',

                    'large'=>'Large',

                    'full'=>'Full',

                ])

                ->default('medium'),






            /*
            |--------------------------------------------------------------------------
            | Shadow
            |--------------------------------------------------------------------------
            */


            Select::make('data.shadow')

                ->label('Shadow')

                ->options([

                    'none'=>'None',

                    'small'=>'Small',

                    'medium'=>'Medium',

                    'large'=>'Large',

                ])

                ->default('none'),






            /*
            |--------------------------------------------------------------------------
            | Hover Effect
            |--------------------------------------------------------------------------
            */


            Select::make('data.hover')

                ->label('Hover Effect')

                ->options([

                    'none'=>'None',

                    'zoom'=>'Zoom',

                    'lift'=>'Lift',

                    'gray'=>'Grayscale',

                ])

                ->default('none'),






            /*
            |--------------------------------------------------------------------------
            | Object Fit
            |--------------------------------------------------------------------------
            */


            Select::make('data.fit')

                ->label('Image Fit')

                ->options([

                    'cover'=>'Cover',

                    'contain'=>'Contain',

                ])

                ->default('cover'),






            /*
            |--------------------------------------------------------------------------
            | Lazy Loading
            |--------------------------------------------------------------------------
            */


            Toggle::make('data.lazy')

                ->label('Lazy Loading')

                ->default(true),



        ],


        self::commonSettings()


        );


    }


}