<?php

namespace App\Filament\Resources\SecurityDelegations\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SecurityDelegationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                /*
                |--------------------------------------------------------------------------
                | Delegation
                |--------------------------------------------------------------------------
                */

                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->alignCenter(),

                /*
                |--------------------------------------------------------------------------
                | Delegated By
                |--------------------------------------------------------------------------
                */

                TextColumn::make('delegatedByUser.name')
                    ->label('Delegated By')
                    ->description(
                        fn ($record): ?string =>
                            $record->delegatedByUser?->email
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                /*
                |--------------------------------------------------------------------------
                | Delegated To
                |--------------------------------------------------------------------------
                */

                TextColumn::make('delegatedToUser.name')
                    ->label('Delegated To')
                    ->description(
                        fn ($record): ?string =>
                            $record->delegatedToUser?->email
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                /*
                |--------------------------------------------------------------------------
                | Organization / Scope
                |--------------------------------------------------------------------------
                */

                TextColumn::make('organization.name')
                    ->label('Scope')
                    ->badge()
                    ->formatStateUsing(
                        fn ($state): string =>
                            $state ?: 'Platform'
                    )
                    ->searchable()
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | Permissions
                |--------------------------------------------------------------------------
                */

                TextColumn::make('permissions.name')
                    ->label('Permissions')
                    ->badge()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->searchable()
                    ->placeholder('No permissions')
                    ->tooltip(
                        fn ($record): ?string =>
                            $record->permissions
                                ->pluck('name')
                                ->implode(', ')
                    ),

                /*
                |--------------------------------------------------------------------------
                | Security Status
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'expired' => 'gray',
                        'revoked' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'active' => 'heroicon-o-check-circle',
                        'pending' => 'heroicon-o-clock',
                        'expired' => 'heroicon-o-exclamation-circle',
                        'revoked' => 'heroicon-o-no-symbol',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | Validity
                |--------------------------------------------------------------------------
                */

                TextColumn::make('starts_at')
                    ->label('Starts')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('d M Y')
                    ->placeholder('No expiration')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
