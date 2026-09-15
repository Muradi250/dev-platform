<?php


namespace App\Blocks\Schemas;


use App\Blocks\BaseBlock;


use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Toggle;



class DividerBlock extends BaseBlock
{


    /**
     * Advanced Divider Block
     *
     * Features:
     *
     * - Line
     * - Gradient
     * - Shape Divider
     * - Spacer
     *
     */


    public static function schema(): array
    {


        return array_merge([



            /*
            |--------------------------------------------------------------------------
            | Divider Type
            |--------------------------------------------------------------------------
            */

            Select::make('data.type')

                ->label('Divider Type')

                ->options([

                    'line'      => 'Line Divider',

                    'gradient'  => 'Gradient Divider',

                    'shape'     => 'Shape Divider',

                    'space'     => 'Spacer',

                ])

                ->default('line')

                ->live()

                ->required(),





            /*
            |--------------------------------------------------------------------------
            | Line Style
            |--------------------------------------------------------------------------
            */

            Select::make('data.style')

                ->label('Line Style')

                ->options([

                    'solid'  => 'Solid',

                    'dashed' => 'Dashed',

                    'dotted' => 'Dotted',

                ])

                ->default('solid')

                ->visible(fn($get) =>

                    $get('data.type') === 'line'

                ),





            /*
            |--------------------------------------------------------------------------
            | Shape Library
            |--------------------------------------------------------------------------
            */

            Select::make('data.shape')

                ->label('Shape')

                ->options([


                    'wave'      => 'Wave',


                    'curve'     => 'Curve',


                    'triangle'  => 'Triangle',


                    'slant'     => 'Slant',


                    'mountain'  => 'Mountain',


                    'zigzag'    => 'Zigzag',


                    'steps'     => 'Steps',


                    'arrow'     => 'Arrow',


                    'circle'    => 'Circle',


                    'cloud'     => 'Cloud',


                    'blob'      => 'Blob',


                    'dots'      => 'Dots',


                ])

                ->default('wave')

                ->visible(fn($get) =>

                    $get('data.type') === 'shape'

                ),





            /*
            |--------------------------------------------------------------------------
            | Width
            |--------------------------------------------------------------------------
            */

            Select::make('data.width')

                ->label('Width')

                ->options([

                    'full'   => 'Full Width',

                    'large'  => 'Large',

                    'medium' => 'Medium',

                    'small'  => 'Small',

                ])

                ->default('full'),





            /*
            |--------------------------------------------------------------------------
            | Height
            |--------------------------------------------------------------------------
            */

            Select::make('data.height')

                ->label('Height')

                ->options([

                    'small'  => 'Small',

                    'medium' => 'Medium',

                    'large'  => 'Large',

                    'xl'     => 'Extra Large',

                ])

                ->default('medium'),





            /*
            |--------------------------------------------------------------------------
            | Thickness
            |--------------------------------------------------------------------------
            */

            Select::make('data.thickness')

                ->label('Thickness')

                ->options([

                    '1' => '1px',

                    '2' => '2px',

                    '4' => '4px',

                    '8' => '8px',

                ])

                ->default('1')

                ->visible(fn($get) =>

                    $get('data.type') !== 'space'

                ),





            /*
            |--------------------------------------------------------------------------
            | Color
            |--------------------------------------------------------------------------
            */

            ColorPicker::make('data.color')

                ->label('Color')

                ->default('#e5e7eb'),





            /*
            |--------------------------------------------------------------------------
            | Flip Shape
            |--------------------------------------------------------------------------
            */

            Toggle::make('data.flip')

                ->label('Flip Shape')

                ->default(false)

                ->visible(fn($get) =>

                    $get('data.type') === 'shape'

                ),





        ],


        self::commonSettings()


        );


    }


}