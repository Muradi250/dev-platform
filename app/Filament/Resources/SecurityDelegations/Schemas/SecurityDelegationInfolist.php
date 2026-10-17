<?php

namespace App\Filament\Resources\SecurityDelegations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SecurityDelegationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Security Command Header
                |--------------------------------------------------------------------------
                */

                Section::make('Security Delegation')
                    ->description(
                        'Controlled transfer of security authority within Dev-Platform.'
                    )
                    ->icon('heroicon-o-shield-check')
                    ->schema([

                        TextEntry::make('id')
                            ->label('Delegation ID')
                            ->prefix('#')
                            ->weight('bold'),

                        TextEntry::make('effective_status')
                            ->label('Security Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'pending' => 'warning',
                                'expired' => 'gray',
                                'revoked' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('organization.name')
                            ->label('Security Scope')
                            ->formatStateUsing(
                                fn ($state): string =>
                                    $state ?: 'Platform-wide'
                            ),

                    ])
                    ->columns(3),

                /*
                |--------------------------------------------------------------------------
                | Authority Chain
                |--------------------------------------------------------------------------
                */

                Section::make('Authority Chain')
                    ->description(
                        'The security authority path for this delegation.'
                    )
                    ->icon('heroicon-o-arrows-right-left')
                    ->schema([

                        TextEntry::make('delegatedByUser.name')
                            ->label('Authority Granted By')
                            ->formatStateUsing(
                                fn ($state, $record): string =>
                                    $state
                                    . ' — '
                                    . ($record->delegatedByUser?->email ?? 'No email')
                            )
                            ->weight('bold'),

                        TextEntry::make('delegatedToUser.name')
                            ->label('Authority Granted To')
                            ->formatStateUsing(
                                fn ($state, $record): string =>
                                    $state
                                    . ' — '
                                    . ($record->delegatedToUser?->email ?? 'No email')
                            )
                            ->weight('bold'),

                        TextEntry::make('parentDelegation.id')
                            ->label('Authority Source')
                            ->formatStateUsing(
                                fn ($state): string =>
                                    $state
                                        ? "Delegation #{$state}"
                                        : 'Direct delegation'
                            ),

                    ])
                    ->columns(3),

                /*
                |--------------------------------------------------------------------------
                | Permission Authority
                |--------------------------------------------------------------------------
                */

                Section::make('Permission Authority')
                    ->description(
                        'The system permissions explicitly attached to this delegation.'
                    )
                    ->icon('heroicon-o-key')
                    ->schema([

                        TextEntry::make('permissions.name')
                            ->label('Granted Permissions')
                            ->badge()
                            ->separator(',')
                            ->placeholder('No permissions assigned')
                            ->columnSpanFull(),

                    ]),

                /*
                |--------------------------------------------------------------------------
                | Organizational Scope
                |--------------------------------------------------------------------------
                */

                Section::make('Organizational Scope')
                    ->description(
                        'The organizational context in which this authority applies.'
                    )
                    ->icon('heroicon-o-building-office-2')
                    ->schema([

                        TextEntry::make('organization.name')
                            ->label('Organization')
                            ->formatStateUsing(
                                fn ($state): string =>
                                    $state ?: 'Platform-wide'
                            )
                            ->weight('bold'),

                        TextEntry::make('parentDelegation.id')
                            ->label('Parent Delegation')
                            ->formatStateUsing(
                                fn ($state): string =>
                                    $state
                                        ? "#{$state}"
                                        : 'None'
                            ),

                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Validity Control
                |--------------------------------------------------------------------------
                */

                Section::make('Validity Control')
                    ->description(
                        'Time-based controls governing the lifetime of this security authority.'
                    )
                    ->icon('heroicon-o-clock')
                    ->schema([

                        TextEntry::make('starts_at')
                            ->label('Effective From')
                            ->dateTime()
                            ->placeholder('Not specified'),

                        TextEntry::make('expires_at')
                            ->label('Effective Until')
                            ->dateTime()
                            ->placeholder('No expiration'),

                        TextEntry::make('revoked_at')
                            ->label('Revoked At')
                            ->dateTime()
                            ->placeholder('Not revoked'),

                    ])
                    ->columns(3),

                /*
                |--------------------------------------------------------------------------
                | Administrative Reason
                |--------------------------------------------------------------------------
                */

                Section::make('Administrative Record')
                    ->description(
                        'Administrative context recorded when this authority was delegated.'
                    )
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        TextEntry::make('reason')
                            ->label('Delegation Reason')
                            ->placeholder('No reason provided')
                            ->columnSpanFull(),

                    ]),

                /*
                |--------------------------------------------------------------------------
                | Security Record
                |--------------------------------------------------------------------------
                */

                Section::make('Security Record')
                    ->description(
                        'System-level metadata for this delegation record.'
                    )
                    ->icon('heroicon-o-finger-print')
                    ->schema([

                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),

                    ])
                    ->columns(2),

            ]);
    }
}
