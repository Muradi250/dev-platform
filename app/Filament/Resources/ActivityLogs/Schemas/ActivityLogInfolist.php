<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Log ID')
                            ->prefix('#'),

                        TextEntry::make('created_at')
                            ->label('Time')
                            ->dateTime('Y-m-d H:i:s T'),

                        TextEntry::make('action')
                            ->label('Action')
                            ->badge()
                            ->copyable(),

                        TextEntry::make('category')
                            ->label('Category')
                            ->badge()
                            ->placeholder('Legacy'),

                        TextEntry::make('module')
                            ->label('Module')
                            ->badge()
                            ->placeholder('Legacy'),

                        TextEntry::make('severity')
                            ->label('Severity')
                            ->badge()
                            ->placeholder('info')
                            ->color(fn (?string $state): string => match ($state) {
                                'danger', 'critical' => 'danger',
                                'warning' => 'warning',
                                'success' => 'success',
                                'info' => 'info',
                                default => 'gray',
                            }),

                        TextEntry::make('user.name')
                            ->label('Actor')
                            ->default('System / deleted user'),

                        TextEntry::make('user_id')
                            ->label('Actor ID')
                            ->placeholder('System event'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('No description')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Request & Subject')
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('Not recorded')
                            ->copyable(),

                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->placeholder('Not recorded')
                            ->wrap()
                            ->columnSpanFull(),

                        TextEntry::make('model_type')
                            ->label('Subject Type')
                            ->placeholder('No subject')
                            ->columnSpan(2),

                        TextEntry::make('model_id')
                            ->label('Subject ID')
                            ->placeholder('No subject'),
                    ])
                    ->columns(3),

                Section::make('Additional Context')
                    ->schema([
                        KeyValueEntry::make('context')
                            ->label('Context')
                            ->keyLabel('Field')
                            ->valueLabel('Value')
                            ->placeholder('No additional context')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
