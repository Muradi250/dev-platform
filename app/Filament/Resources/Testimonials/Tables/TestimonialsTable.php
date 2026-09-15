<?php

namespace App\Filament\Resources\Testimonials\Tables;

use App\Models\Testimonial;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | Customer
                |--------------------------------------------------------------------------
                */

                ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(
                        url('/images/default-avatar.png')
                    ),

                TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('company')
                    ->label('Company')
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->placeholder('—'),

                /*
                |--------------------------------------------------------------------------
                | Rating
                |--------------------------------------------------------------------------
                */

                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(
                        fn ($state): string =>
                            $state
                                ? str_repeat('★', (int) $state)
                                : '—'
                    )
                    ->color('warning')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string =>
                            match ($state) {
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                default => ucfirst($state),
                            }
                    )
                    ->color(
                        fn (string $state): string =>
                            match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }
                    )
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | Featured
                |--------------------------------------------------------------------------
                */

                IconColumn::make('featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | Date
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

            ])

            /*
            |--------------------------------------------------------------------------
            | Filters
            |--------------------------------------------------------------------------
            */

            ->filters([

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                TernaryFilter::make('featured')
                    ->label('Featured'),

            ])

            /*
            |--------------------------------------------------------------------------
            | Row Actions
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                /*
                | View
                */

                ViewAction::make(),

                /*
                | Approve
                */

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(
                        fn (Testimonial $record): bool =>
                            $record->status !== 'approved'
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Approve Testimonial')
                    ->modalDescription(
                        'Are you sure you want to approve this testimonial? It will become available for publication on the website.'
                    )
                    ->action(function (Testimonial $record): void {

                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                        ]);

                    }),

                /*
                | Reject
                */

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(
                        fn (Testimonial $record): bool =>
                            $record->status !== 'rejected'
                    )
                    ->requiresConfirmation()
                    ->modalHeading('Reject Testimonial')
                    ->modalDescription(
                        'Are you sure you want to reject this testimonial?'
                    )
                    ->action(function (Testimonial $record): void {

                        $record->update([
                            'status' => 'rejected',
                            'approved_at' => null,
                            'featured' => false,
                        ]);

                    }),

                /*
                | Edit
                */

                EditAction::make(),

                /*
                | Delete
                */

                DeleteAction::make(),

            ])

            /*
            |--------------------------------------------------------------------------
            | Bulk Actions
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ]);
    }
}