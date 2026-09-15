<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TestimonialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Customer Information
                |--------------------------------------------------------------------------
                */

                ImageEntry::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular()
                    ->height(100),

                TextEntry::make('name')
                    ->label('Customer Name')
                    ->weight('bold'),

                TextEntry::make('email')
                    ->label('Email')
                    ->placeholder('Not provided'),

                TextEntry::make('company')
                    ->label('Company')
                    ->placeholder('Not provided'),

                TextEntry::make('position')
                    ->label('Position')
                    ->placeholder('Not provided'),

                /*
                |--------------------------------------------------------------------------
                | Testimonial
                |--------------------------------------------------------------------------
                */

                TextEntry::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(
                        fn ($state): string =>
                            $state
                                ? str_repeat('★', (int) $state)
                                : 'Not rated'
                    ),

                TextEntry::make('message')
                    ->label('Customer Testimonial')
                    ->columnSpanFull()
                    ->prose(),

                /*
                |--------------------------------------------------------------------------
                | Moderation
                |--------------------------------------------------------------------------
                */

                TextEntry::make('status')
                    ->label('Publication Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        }
                    ),

                TextEntry::make('featured')
                    ->label('Featured')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string =>
                            $state ? 'Yes' : 'No'
                    )
                    ->color(
                        fn (bool $state): string =>
                            $state ? 'success' : 'gray'
                    ),

                TextEntry::make('approved_at')
                    ->label('Approved At')
                    ->dateTime()
                    ->placeholder('Not approved yet'),

                /*
                |--------------------------------------------------------------------------
                | Timestamps
                |--------------------------------------------------------------------------
                */

                TextEntry::make('created_at')
                    ->label('Submitted At')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(),

            ]);
    }
}