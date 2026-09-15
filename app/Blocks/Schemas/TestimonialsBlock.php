<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class TestimonialsBlock extends BaseBlock
{
    public static function schema(): array
    {
        return array_merge([

            /*
            |--------------------------------------------------------------------------
            | Section Information
            |--------------------------------------------------------------------------
            */

            Section::make('Section Information')
                ->description(
                    'Configure the heading and introduction of the testimonials section.'
                )
                ->schema([

                    TextInput::make('data.title')
                        ->label('Section Title')
                        ->placeholder('What Our Customers Say')
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Textarea::make('data.description')
                        ->label('Section Description')
                        ->placeholder(
                            'See what our customers and partners have to say.'
                        )
                        ->rows(3)
                        ->maxLength(1000)
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | Testimonials
            |--------------------------------------------------------------------------
            */

            Section::make('Testimonials')
                ->description(
                    'Add and manage customer testimonials displayed on the website.'
                )
                ->schema([

                    Repeater::make('data.testimonials')
                        ->label('Customer Testimonials')
                        ->schema([

                            /*
                            |--------------------------------------------------------------------------
                            | Customer Avatar
                            |--------------------------------------------------------------------------
                            */

                            FileUpload::make('avatar')
                                ->label('Customer Avatar')
                                ->image()
                                ->disk('public')
                                ->directory('testimonials')
                                ->visibility('public')
                                ->imageEditor()
                                ->imagePreviewHeight('120')
                                ->maxSize(2048)
                                ->columnSpanFull(),

                            /*
                            |--------------------------------------------------------------------------
                            | Customer Information
                            |--------------------------------------------------------------------------
                            */

                            TextInput::make('name')
                                ->label('Customer Name')
                                ->placeholder('John Doe')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('position')
                                ->label('Position')
                                ->placeholder('CEO')
                                ->maxLength(255),

                            TextInput::make('company')
                                ->label('Company')
                                ->placeholder('Company Name')
                                ->maxLength(255),

                            /*
                            |--------------------------------------------------------------------------
                            | Testimonial
                            |--------------------------------------------------------------------------
                            */

                            Textarea::make('content')
                                ->label('Testimonial')
                                ->placeholder(
                                    'Write the customer testimonial here...'
                                )
                                ->required()
                                ->rows(5)
                                ->maxLength(2000)
                                ->columnSpanFull(),

                            /*
                            |--------------------------------------------------------------------------
                            | Rating
                            |--------------------------------------------------------------------------
                            */

                            Select::make('rating')
                                ->label('Rating')
                                ->options([
                                    1 => '1 Star',
                                    2 => '2 Stars',
                                    3 => '3 Stars',
                                    4 => '4 Stars',
                                    5 => '5 Stars',
                                ])
                                ->default(5)
                                ->native(false),

                            Toggle::make('approved')
                                ->label('Approved')
                                ->helperText(
                                    'Only approved testimonials should be displayed publicly.'
                                )
                                ->default(true),

                        ])
                        ->columns(2)
                        ->defaultItems(1)
                        ->addActionLabel('Add Testimonial')
                        ->reorderable()
                        ->collapsible()
                        ->cloneable()
                        ->columnSpanFull(),

                ])
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | Display Settings
            |--------------------------------------------------------------------------
            */

            Section::make('Display Reviews')
                ->description(
                    'Control how testimonials are displayed on the website.'
                )
                ->schema([

                    Toggle::make('data.display.enabled')
                        ->label('Enable Testimonials')
                        ->helperText(
                            'Enable or disable the testimonials section.'
                        )
                        ->default(true),

                    Select::make('data.display.layout')
                        ->label('Display Layout')
                        ->options([
                            'grid' => 'Grid',
                            'list' => 'List',
                            'carousel' => 'Carousel',
                        ])
                        ->default('grid')
                        ->native(false),

                    Select::make('data.display.limit')
                        ->label('Number of Reviews')
                        ->options([
                            3 => '3 Reviews',
                            6 => '6 Reviews',
                            9 => '9 Reviews',
                            12 => '12 Reviews',
                            0 => 'All Reviews',
                        ])
                        ->default(6)
                        ->native(false),

                    Toggle::make('data.display.show_rating')
                        ->label('Show Rating')
                        ->default(true),

                    Toggle::make('data.display.show_avatar')
                        ->label('Show Avatar')
                        ->default(true),

                    Toggle::make('data.display.show_company')
                        ->label('Show Company')
                        ->default(true),

                    Toggle::make('data.display.show_position')
                        ->label('Show Position')
                        ->default(true),

                ])
                ->columns(2)
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | Submission Form
            |--------------------------------------------------------------------------
            */

            Section::make('Submit Testimonial')
                ->description(
                    'Configure the public testimonial submission form.'
                )
                ->schema([

                    Toggle::make('data.form.enabled')
                        ->label('Enable Submission Form')
                        ->helperText(
                            'Allow visitors to submit their testimonials.'
                        )
                        ->default(true)
                        ->live(),

                    TextInput::make('data.form.url')
                        ->label('Form URL')
                        ->placeholder('/en/testimonials/submit')
                        ->helperText(
                            'URL where the testimonial submission form will be displayed.'
                        )
                        ->maxLength(500)
                        ->url()
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                    Toggle::make('data.form.require_email')
                        ->label('Require Email')
                        ->default(false)
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                    Toggle::make('data.form.allow_rating')
                        ->label('Allow Rating')
                        ->default(true)
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                    Toggle::make('data.form.allow_avatar')
                        ->label('Allow Avatar')
                        ->default(true)
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                    Toggle::make('data.form.require_company')
                        ->label('Require Company')
                        ->default(false)
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                    Toggle::make('data.form.require_position')
                        ->label('Require Position')
                        ->default(false)
                        ->visible(
                            fn ($get) =>
                                $get('data.form.enabled')
                        ),

                ])
                ->columns(2)
                ->columnSpanFull(),


            /*
            |--------------------------------------------------------------------------
            | Moderation
            |--------------------------------------------------------------------------
            */

            Section::make('Moderation')
                ->description(
                    'Control the messages shown after testimonial submission.'
                )
                ->schema([

                    Textarea::make('data.form.success_message')
                        ->label('Success Message')
                        ->default(
                            'Thank you! Your testimonial has been submitted and is awaiting approval.'
                        )
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Textarea::make('data.form.pending_message')
                        ->label('Pending Message')
                        ->default(
                            'Your testimonial has been received and is awaiting review.'
                        )
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),

                ])
                ->columns(2)
                ->columnSpanFull(),


        ], self::commonSettings());
    }
}