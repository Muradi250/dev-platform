<?php

namespace App\Filament\Resources\Pages\RelationManagers;


/*
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
*/

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;


/*
|--------------------------------------------------------------------------
| Form Components
|--------------------------------------------------------------------------
*/

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;


/*
|--------------------------------------------------------------------------
| Relation Manager
|--------------------------------------------------------------------------
*/

use Filament\Resources\RelationManagers\RelationManager;


/*
|--------------------------------------------------------------------------
| Schema
|--------------------------------------------------------------------------
*/

use Filament\Schemas\Schema;


/*
|--------------------------------------------------------------------------
| Table
|--------------------------------------------------------------------------
*/

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;



class BlocksRelationManager extends RelationManager
{


    /*
    |--------------------------------------------------------------------------
    | ارتباط با Page
    |--------------------------------------------------------------------------
    |
    | هر صفحه چند Block دارد.
    |
    */

    protected static string $relationship = 'blocks';






    /*
    |--------------------------------------------------------------------------
    | فرم ایجاد و ویرایش Block
    |--------------------------------------------------------------------------
    |
    | اینجا Page Builder ساخته می‌شود.
    |
    | هر Block فرم اختصاصی خودش را دارد.
    |
    */

    public function form(Schema $schema): Schema
    {

        return $schema->components([




            /*
            |--------------------------------------------------------------------------
            | انتخاب نوع Block
            |--------------------------------------------------------------------------
            */

            Select::make('type')

                ->label('Block Type')

                ->options([

                    'hero' =>
                    'Hero Section',

                    'services' =>
                    'Services',

                    'team' =>
                    'Team',

                    'faq' =>
                    'FAQ',

                    'pricing' =>
                    'Pricing',

                ])

                ->live()

                ->required(),






            /*
            |--------------------------------------------------------------------------
            | HERO SECTION
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.title')

                ->label('Hero Title')

                ->visible(fn ($get) =>
                    $get('type') === 'hero'
                ),



            Textarea::make('data.subtitle')

                ->label('Hero Subtitle')

                ->rows(3)

                ->visible(fn ($get) =>
                    $get('type') === 'hero'
                ),



            TextInput::make('data.button_text')

                ->label('Button Text')

                ->visible(fn ($get) =>
                    $get('type') === 'hero'
                ),



            TextInput::make('data.button_url')

                ->label('Button URL')

                ->visible(fn ($get) =>
                    $get('type') === 'hero'
                ),






            /*
            |--------------------------------------------------------------------------
            | SERVICES SECTION
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.section_title')

                ->label('Services Section Title')

                ->visible(fn ($get) =>
                    $get('type') === 'services'
                ),



            Repeater::make('data.items')

                ->label('Services')

                ->visible(fn ($get) =>
                    $get('type') === 'services'
                )

                ->schema([


                    TextInput::make('icon')

                        ->label('Icon'),



                    TextInput::make('title')

                        ->label('Service Title')

                        ->required(),



                    Textarea::make('description')

                        ->label('Description')

                        ->rows(3),


                ])

                ->defaultItems(1)

                ->addActionLabel('Add Service')

                ->collapsible(),






            /*
            |--------------------------------------------------------------------------
            | TEAM SECTION
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.section_title')

                ->label('Team Section Title')

                ->visible(fn ($get) =>
                    $get('type') === 'team'
                ),



            Repeater::make('data.members')

                ->label('Team Members')

                ->visible(fn ($get) =>
                    $get('type') === 'team'
                )

                ->schema([


                    TextInput::make('name')

                        ->label('Name')

                        ->required(),



                    TextInput::make('position')

                        ->label('Position'),



                    Textarea::make('bio')

                        ->label('Biography'),

                ])

                ->addActionLabel('Add Member')

                ->collapsible(),






            /*
            |--------------------------------------------------------------------------
            | FAQ SECTION
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.section_title')

                ->label('FAQ Section Title')

                ->visible(fn ($get) =>
                    $get('type') === 'faq'
                ),



            Repeater::make('data.questions')

                ->label('FAQ Questions')

                ->visible(fn ($get) =>
                    $get('type') === 'faq'
                )

                ->schema([


                    TextInput::make('question')

                        ->label('Question')

                        ->required(),



                    Textarea::make('answer')

                        ->label('Answer')

                        ->required(),


                ])

                ->addActionLabel('Add Question')

                ->collapsible(),






            /*
            |--------------------------------------------------------------------------
            | PRICING SECTION
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.section_title')

                ->label('Pricing Section Title')

                ->visible(fn ($get) =>
                    $get('type') === 'pricing'
                ),



            Repeater::make('data.plans')

                ->label('Pricing Plans')

                ->visible(fn ($get) =>
                    $get('type') === 'pricing'
                )

                ->schema([


                    TextInput::make('name')

                        ->label('Plan Name')

                        ->required(),



                    TextInput::make('price')

                        ->label('Price'),



                    Textarea::make('features')

                        ->label('Features'),



                    TextInput::make('button_text')

                        ->label('Button Text'),



                    TextInput::make('button_url')

                        ->label('Button URL'),

                ])

                ->addActionLabel('Add Plan')

                ->collapsible(),






            /*
            |--------------------------------------------------------------------------
            | ترتیب نمایش Block
            |--------------------------------------------------------------------------
            */

            TextInput::make('sort_order')

                ->label('Order')

                ->numeric()

                ->default(1),


        ]);

    }








    /*
    |--------------------------------------------------------------------------
    | جدول نمایش Block ها
    |--------------------------------------------------------------------------
    */

    public function table(Table $table): Table
    {

        return $table


            ->columns([


                TextColumn::make('type')

                    ->label('Block Type')

                    ->formatStateUsing(fn ($state) => match ($state) {


                        'hero' =>
                        'Hero Section',


                        'services' =>
                        'Services',


                        'team' =>
                        'Team',


                        'faq' =>
                        'FAQ',


                        'pricing' =>
                        'Pricing',


                        default =>
                        $state,


                    }),



                TextColumn::make('sort_order')

                    ->label('Order'),



                IconColumn::make('is_active')

                    ->label('Active')

                    ->boolean(),


            ])




            ->headerActions([

                CreateAction::make(),

            ])




            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ]);

    }


}