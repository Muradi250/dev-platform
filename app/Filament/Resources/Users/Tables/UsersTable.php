<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 👤 Name
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold'),

                // 📧 Email
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                // 🎭 Roles (FIXED + CLEAN)
                TextColumn::make('roles')
                    ->label('Roles')
                    ->formatStateUsing(fn ($record) =>
                        $record->roles->pluck('name')->join(', ')
                    )
                    ->badge()
                    ->color(fn ($record) =>
                        $record->roles->contains('name', 'super-admin') ? 'danger' :
                        ($record->roles->contains('name', 'admin') ? 'primary' : 'gray')
                    ),

                // 🔐 STATUS (REAL SYSTEM)
                SelectColumn::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'suspended' => 'Suspended',
                        'banned' => 'Banned',
                    ])
                    ->sortable(),

                // 📅 Created At
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])

            // 🔍 Filters (future upgrade)
            ->filters([
                //
            ])

            // ⚙ Actions
            ->recordActions([
                EditAction::make(),
            ])

            // 🧹 Bulk Actions
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}