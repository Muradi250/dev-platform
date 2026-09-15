<?php

namespace App\Blocks\Schemas;

use App\Blocks\BaseBlock;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class ContactBlock extends BaseBlock
{
    /*
    |--------------------------------------------------------------------------
    | Contact Block
    |--------------------------------------------------------------------------
    |
    | Modern glass-style contact information block.
    |
    | This block is designed for:
    |
    | - Personal websites
    | - Online businesses
    | - Freelancers
    | - Digital platforms
    | - SaaS websites
    |
    | The contact form itself is intentionally NOT included here.
    | A dedicated Contact Page will handle message submission.
    |
    |--------------------------------------------------------------------------
    */

    public static function schema(): array
    {
        return array_merge([

            /*
            |--------------------------------------------------------------------------
            | Header
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.title')
                ->label('Contact Title')
                ->placeholder('Get in Touch')
                ->maxLength(255),

            Textarea::make('data.description')
                ->label('Description')
                ->placeholder(
                    'Have a question or want to work together? Feel free to reach out.'
                )
                ->rows(4)
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Email
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.email')
                ->label('Email')
                ->placeholder('hello@example.com')
                ->email()
                ->maxLength(255),

            /*
            |--------------------------------------------------------------------------
            | Phone
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.phone')
                ->label('Phone')
                ->placeholder('+93 700 000 000')
                ->maxLength(50),

            /*
            |--------------------------------------------------------------------------
            | WhatsApp
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.whatsapp')
                ->label('WhatsApp')
                ->placeholder('+93 700 000 000')
                ->maxLength(50),

            /*
            |--------------------------------------------------------------------------
            | Telegram
            |--------------------------------------------------------------------------
            */

            TextInput::make('data.telegram')
                ->label('Telegram Username / Link')
                ->placeholder('@username')
                ->maxLength(255),

            /*
            |--------------------------------------------------------------------------
            | Working Hours
            |--------------------------------------------------------------------------
            */

            Textarea::make('data.working_hours')
                ->label('Availability')
                ->placeholder(
                    'Available online — Saturday to Thursday'
                )
                ->rows(3)
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | Social Links
            |--------------------------------------------------------------------------
            */

            Repeater::make('data.social_links')
                ->label('Social Links')
                ->schema([

                    TextInput::make('label')
                        ->label('Name')
                        ->placeholder('LinkedIn')
                        ->required()
                        ->maxLength(50),

                    TextInput::make('url')
                        ->label('URL')
                        ->placeholder('https://...')
                        ->url()
                        ->required()
                        ->maxLength(500),

                    Select::make('icon')
                        ->label('Icon')
                        ->options([
                            'linkedin'  => 'LinkedIn',
                            'facebook'  => 'Facebook',
                            'instagram' => 'Instagram',
                            'youtube'   => 'YouTube',
                            'github'    => 'GitHub',
                            'x'         => 'X',
                            'website'   => 'Website',
                        ])
                        ->default('website')
                        ->required(),

                ])
                ->columns(3)
                ->defaultItems(0)
                ->addActionLabel('Add Social Link')
                ->reorderable()
                ->collapsible()
                ->columnSpanFull(),

        ], self::commonSettings());
    }
}
