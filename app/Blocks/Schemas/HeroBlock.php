<?php

namespace App\Blocks\Schemas;


use App\Blocks\BaseBlock;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;



class HeroBlock extends BaseBlock
{


    public static function schema(): array
    {


        return array_merge([



            /*
            |--------------------------------------------------------------------------
            | Hero Content
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.eyebrow')

                ->label('Eyebrow Text')

                ->placeholder('Enterprise Platform')

                ->maxLength(100),




            TextInput::make('data.badge')

                ->label(__('blocks.hero.badge'))

                ->placeholder('New')

                ->maxLength(100),






            TextInput::make('data.title')

                ->label(__('blocks.hero.title'))

                ->required()

                ->maxLength(255)

                ->columnSpanFull(),





            TextInput::make('data.highlight')

                ->label('Highlighted Text')

                ->placeholder('Digital Transformation'),





            Textarea::make('data.description')

                ->label(__('blocks.hero.description'))

                ->rows(5)

                ->columnSpanFull(),






            /*
            |--------------------------------------------------------------------------
            | Buttons
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.primary_button_text')

                ->label(__('blocks.hero.primary_button_text'))

                ->placeholder('Get Started'),





            TextInput::make('data.primary_button_url')

                ->label(__('blocks.hero.primary_button_url'))

                ->placeholder('/register'),






            TextInput::make('data.secondary_button_text')

                ->label(__('blocks.hero.secondary_button_text')),





            TextInput::make('data.secondary_button_url')

                ->label(__('blocks.hero.secondary_button_url'))

                ->placeholder('/contact'),







            /*
            |--------------------------------------------------------------------------
            | Layout
            |--------------------------------------------------------------------------
            */


            Select::make('data.layout')

                ->label(__('blocks.hero.layout'))

                ->options([


                    'center' => __('blocks.hero.center'),


                    'split' => __('blocks.hero.split'),


                    'image_right' => __('blocks.hero.image_right'),


                ])


                ->default('split'),







            Select::make('data.height')

                ->label(__('blocks.hero.height'))

                ->options([


                    'medium' => __('blocks.hero.medium'),


                    'large' => __('blocks.hero.large'),


                    'screen' => __('blocks.hero.full_screen'),


                ])


                ->default('screen'),






            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */


            Select::make('data.media_type')

                ->label('Hero Media Type')

                ->options([


                    'dashboard'=>'Dashboard Preview',


                    'image'=>'Image',


                    'video'=>'Video',


                ])


                ->default('dashboard'),






            TextInput::make('data.media_url')

                ->label('Media URL')

                ->placeholder('/storage/hero.png'),







            /*
            |--------------------------------------------------------------------------
            | Style
            |--------------------------------------------------------------------------
            */


            Select::make('data.text_color')

                ->label(__('blocks.hero.text_color'))

                ->options([


                    'dark'=>__('blocks.hero.dark'),


                    'light'=>__('blocks.hero.light'),


                ])


                ->default('light'),





            Select::make('data.animation')

                ->label('Animation')

                ->options([


                    'none'=>'None',


                    'fade'=>'Fade In',


                    'slide'=>'Slide Up',


                    'zoom'=>'Zoom',


                ])


                ->default('fade'),






            Toggle::make('data.show_dashboard')

                ->label(__('blocks.hero.show_dashboard'))

                ->default(true),





            /*
            |--------------------------------------------------------------------------
            | Dashboard Statistics
            |--------------------------------------------------------------------------
            */


            TextInput::make('data.stats_users')

                ->label('Dashboard Users')

                ->default('1250'),




            TextInput::make('data.stats_organizations')

                ->label('Organizations')

                ->default('85'),





            TextInput::make('data.stats_modules')

                ->label('Modules')

                ->default('12'),





        ],



        self::commonSettings()



        );


    }


}