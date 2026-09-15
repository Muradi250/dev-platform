<?php


namespace App\Blocks;


use Filament\Schemas\Components\Section;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;



abstract class BaseBlock
{


    /**
     * هر Block باید Schema خودش را داشته باشد
     */
    abstract public static function schema(): array;





    /**
     * تنظیمات مشترک تمام Block ها
     */
    public static function commonSettings(): array
    {


        return [


            Section::make(
                __('blocks.common.global_settings')
            )


            ->description(
                __('blocks.common.common_settings')
            )


            ->schema([




                /*
                |--------------------------------------------------------------------------
                | Section ID
                |--------------------------------------------------------------------------
                */

                TextInput::make(
                    'settings.section_id'
                )


                ->label('Section ID')

                ->placeholder('pricing')

                ->helperText(
                    'Used for anchor links (#pricing)'
                ),






                /*
                |--------------------------------------------------------------------------
                | Container
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.container'
                )


                ->label(
                    __('blocks.common.container')
                )


                ->options([


                    'default'=>__('blocks.common.default'),


                    'wide'=>__('blocks.common.wide'),


                    'full'=>__('blocks.common.full'),


                ])


                ->default('default'),







                /*
                |--------------------------------------------------------------------------
                | Desktop Padding
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.padding'
                )


                ->label(
                    'Desktop Padding'
                )


                ->options([


                    'none'=>'None',


                    'small'=>'Small',


                    'medium'=>'Medium',


                    'large'=>'Large',


                ])


                ->default('medium'),







                /*
                |--------------------------------------------------------------------------
                | Mobile Padding
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.mobile_padding'
                )


                ->label(
                    'Mobile Padding'
                )


                ->options([


                    'none'=>'None',


                    'small'=>'Small',


                    'medium'=>'Medium',


                    'large'=>'Large',


                ])


                ->default('small'),







                /*
                |--------------------------------------------------------------------------
                | Background Color
                |--------------------------------------------------------------------------
                */


                ColorPicker::make(
                    'settings.background.color'
                )


                ->label(
                    __('blocks.common.background_color')
                ),






                /*
                |--------------------------------------------------------------------------
                | Background Image
                |--------------------------------------------------------------------------
                */


                FileUpload::make(
                    'settings.background.image'
                )


                ->label(
                    __('blocks.common.background_image')
                )


                ->image()


                ->disk('public')


                ->directory(
                    'blocks/backgrounds'
                )


                ->visibility('public')


                ->previewable()


                ->openable()


                ->downloadable()


                ->preserveFilenames()


                ->maxSize(5120),







                /*
                |--------------------------------------------------------------------------
                | Background Overlay
                |--------------------------------------------------------------------------
                */


                Toggle::make(
                    'settings.background.overlay'
                )


                ->label(
                    'Background Overlay'
                )


                ->default(true),







                /*
                |--------------------------------------------------------------------------
                | Background Position
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.background.position'
                )


                ->label(
                    'Background Position'
                )


                ->options([


                    'center'=>'Center',


                    'top'=>'Top',


                    'bottom'=>'Bottom',


                ])


                ->default('center'),







                /*
                |--------------------------------------------------------------------------
                | Text Color
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.text_color'
                )


                ->label(
                    __('blocks.common.text_color')
                )


                ->options([


                    'dark'=>__('blocks.common.dark'),


                    'light'=>__('blocks.common.light'),


                ])


                ->default('dark'),







                /*
                |--------------------------------------------------------------------------
                | Animation
                |--------------------------------------------------------------------------
                */


                Select::make(
                    'settings.animation'
                )


                ->label(
                    'Animation'
                )


                ->options([


                    'none'=>'None',


                    'fade'=>'Fade In',


                    'slide'=>'Slide Up',


                    'zoom'=>'Zoom',


                ])


                ->default('none'),







                /*
                |--------------------------------------------------------------------------
                | Responsive Visibility
                |--------------------------------------------------------------------------
                */


                Toggle::make(
                    'settings.visible'
                )


                ->label(
                    __('blocks.common.visible')
                )


                ->default(true),





                Toggle::make(
                    'settings.show_mobile'
                )


                ->label(
                    'Show on Mobile'
                )


                ->default(true),





                Toggle::make(
                    'settings.show_desktop'
                )


                ->label(
                    'Show on Desktop'
                )


                ->default(true),







                /*
                |--------------------------------------------------------------------------
                | Custom Class
                |--------------------------------------------------------------------------
                */


                TextInput::make(
                    'settings.custom_class'
                )


                ->label(
                    __('blocks.common.custom_class')
                ),







                /*
                |--------------------------------------------------------------------------
                | Custom CSS
                |--------------------------------------------------------------------------
                */


                Textarea::make(
                    'settings.custom_css'
                )


                ->label(
                    __('blocks.common.custom_css')
                )


                ->rows(8)


                ->columnSpanFull(),





            ])


            ->columns(2)


            ->collapsible(),


        ];

    }



}