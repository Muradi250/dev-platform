<?php

namespace App\Filament\Resources\DemoRequests\Tables;

use App\Models\DemoRequest;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DemoRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('company')
                    ->searchable(),

                TextColumn::make('team_size')
                    ->label('Team Size')
                    ->placeholder('Not provided'),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'closed' => 'Closed',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'closed' => 'Closed',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('markContacted')
                    ->label('Mark contacted')
                    ->icon('heroicon-o-phone')
                    ->color('info')
                    ->visible(fn (DemoRequest $record): bool => $record->status === 'new')
                    ->action(fn (DemoRequest $record) => $record->update([
                        'status' => 'contacted',
                    ])),

                Action::make('close')
                    ->label('Close')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (DemoRequest $record): bool => $record->status !== 'closed')
                    ->action(fn (DemoRequest $record) => $record->update([
                        'status' => 'closed',
                    ])),
            ]);
    }
}
