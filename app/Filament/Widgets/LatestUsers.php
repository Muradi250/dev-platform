<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestUsers extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->with('roles')
                    ->latest()
                    ->limit(5)
            )

            ->columns([

                // 🆔 ID
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('#'),

                // 👤 Name
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->weight('bold'),

                // 📧 Email
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                // 🎭 Roles (PRO FIX)
                Tables\Columns\TextColumn::make('roles')
                    ->formatStateUsing(fn ($record) =>
                        $record->roles->pluck('name')->join(', ')
                    )
                    ->badge()
                    ->color(fn ($record) =>
                        $record->roles->contains('name', 'super-admin') ? 'danger' :
                        ($record->roles->contains('name', 'admin') ? 'primary' : 'gray')
                    ),

                // 🔐 STATUS (FIXED → using real system)
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->status_label)
                    ->color(fn ($record) => $record->status_color),

                // 📅 Created
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Joined'),
            ])

            ->actions([])
            ->bulkActions([]);
    }
}