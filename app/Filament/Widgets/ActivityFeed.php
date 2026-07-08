<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActivityFeed extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ActivityLog::query()->with('user')->latest()
            )

            // 🎯 Filters (خیلی مهم برای حرفه‌ای شدن)
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options([
                        'auth.login' => 'Login',
                        'auth.logout' => 'Logout',
                        'users.create' => 'User Created',
                        'users.update' => 'User Updated',
                        'users.delete' => 'User Deleted',
                    ]),

                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name'),
            ])

            ->columns([

                // 👤 User
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),

                // ⚡ Action
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->icon(fn (string $state) => match ($state) {

                        'auth.login' => 'heroicon-o-arrow-right-end-on-rectangle',
                        'auth.logout' => 'heroicon-o-arrow-left-start-on-rectangle',

                        'users.create' => 'heroicon-o-user-plus',
                        'users.update' => 'heroicon-o-pencil-square',
                        'users.delete' => 'heroicon-o-trash',

                        'roles.create' => 'heroicon-o-shield-check',
                        'roles.update' => 'heroicon-o-shield-exclamation',
                        'roles.delete' => 'heroicon-o-shield-exclamation',

                        default => 'heroicon-o-information-circle',
                    })
                    ->color(fn (string $state) => match ($state) {

                        'auth.login' => 'success',
                        'auth.logout' => 'warning',

                        'users.create' => 'success',
                        'users.update' => 'info',
                        'users.delete' => 'danger',

                        'roles.create' => 'primary',
                        'roles.update' => 'warning',
                        'roles.delete' => 'danger',

                        default => 'gray',
                    }),

                // 📝 Description
                Tables\Columns\TextColumn::make('description')
                    ->limit(70)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap(),

                // 🌐 IP
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),

                // ⏱ Time
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])

            // 🔄 Auto refresh (live dashboard feel)
            ->poll('10s');
    }
}