<?php

namespace App\Filament\Resources\Pages\Schemas;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Illuminate\Support\Str;



class PageForm
{


    public static function configure(Schema $schema): Schema
    {

        return $schema

            ->components([



                /*
                |--------------------------------------------------------------------------
                | Page Information
                |--------------------------------------------------------------------------
                */


                Section::make('Page Information')

                    ->schema([



                        TextInput::make('title')

                            ->label('Page Title')

                            ->required()

                            ->maxLength(255)



                            ->live(onBlur: true)



                            ->afterStateUpdated(function ($state, callable $set) {


                                $set(

                                    'slug',

                                    Str::slug($state)

                                );


                            }),






                        TextInput::make('slug')

                            ->label('URL Slug')

                            ->required()

                            ->maxLength(255)



                            ->unique(

                                table: 'pages',

                                column: 'slug',

                                ignoreRecord: true

                            ),







                        Select::make('locale')

                            ->label('Language')

                            ->options([


                                'en' => 'English',


                                'fa' => 'فارسی',


                                'ps' => 'پښتو',


                            ])

                            ->default('en')

                            ->required(),



                    ])

                    ->columns(2),







                /*
                |--------------------------------------------------------------------------
                | Page Content
                |--------------------------------------------------------------------------
                */


                Section::make('Content')

                    ->schema([



                        Textarea::make('content')

                            ->label('Page Content')

                            ->rows(8),



                    ]),







                /*
                |--------------------------------------------------------------------------
                | Publishing
                |--------------------------------------------------------------------------
                */


                Section::make('Publishing')


                    ->schema([



                        Select::make('status')


                            ->label('Status')


                            ->options([



                                'draft' => 'Draft',


                                'published' => 'Published',


                            ])


                            ->default('draft')


                            ->required(),



                    ]),







                /*
                |--------------------------------------------------------------------------
                | SEO Settings
                |--------------------------------------------------------------------------
                */


                Section::make('SEO Settings')


                    ->schema([




                        TextInput::make('seo_title')


                            ->label('SEO Title')


                            ->maxLength(60),






                        Textarea::make('seo_description')


                            ->label('SEO Description')


                            ->rows(4)


                            ->maxLength(160),



                    ]),




            ]);

    }

}