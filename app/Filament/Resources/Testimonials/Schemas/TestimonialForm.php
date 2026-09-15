<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Customer Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),

                TextInput::make('company')
                    ->label('Company')
                    ->maxLength(255),

                TextInput::make('position')
                    ->label('Position')
                    ->maxLength(255),

                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->disk('public')
                    ->directory('testimonials')
                    ->imagePreviewHeight('120')
                    ->nullable(),

                Select::make('rating')
                    ->label('Rating')
                    ->options([
                        1 => '★ 1',
                        2 => '★ 2',
                        3 => '★ 3',
                        4 => '★ 4',
                        5 => '★ 5',
                    ])
                    ->native(false)
                    ->nullable(),

                Textarea::make('message')
                    ->label('Customer Testimonial')
                    ->required()
                    ->rows(6)
                    ->maxLength(2000)
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Publication Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending')
                    ->native(false),

                Toggle::make('featured')
                    ->label('Featured Testimonial')
                    ->helperText('Featured testimonials can be highlighted on the website.')
                    ->default(false),

                DateTimePicker::make('approved_at')
                    ->label('Approved At')
                    ->nullable(),

            ]);
    }
}