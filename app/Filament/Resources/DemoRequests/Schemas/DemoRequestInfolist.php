<?php

namespace App\Filament\Resources\DemoRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DemoRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name')
                    ->weight('bold'),

                TextEntry::make('email')
                    ->label('Email')
                    ->copyable(),

                TextEntry::make('company')
                    ->label('Organization'),

                TextEntry::make('phone')
                    ->label('Phone')
                    ->placeholder('Not provided'),

                TextEntry::make('team_size')
                    ->label('Team Size')
                    ->placeholder('Not provided'),

                TextEntry::make('locale')
                    ->label('Submitted Language'),

                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        'closed' => 'success',
                        default => 'gray',
                    }),

                TextEntry::make('message')
                    ->label('What They Would Like to See')
                    ->placeholder('No message provided')
                    ->columnSpanFull()
                    ->prose(),

                TextEntry::make('created_at')
                    ->label('Received')
                    ->dateTime(),
            ]);
    }
}
