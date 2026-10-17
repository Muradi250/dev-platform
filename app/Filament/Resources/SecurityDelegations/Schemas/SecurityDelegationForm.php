<?php

namespace App\Filament\Resources\SecurityDelegations\Schemas;

use App\Models\SecurityDelegation;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class SecurityDelegationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Delegation Authority')
                    ->description(
                        'Define the user who will receive delegated security authority.'
                    )
                    ->schema([

                        Select::make('delegated_to_user_id')
                            ->label('Delegate To')
                            ->relationship(
                                'delegatedToUser',
                                'name',
                                modifyQueryUsing: function ($query) {
                                    $query
                                        ->where('is_owner', false)
                                        ->where('status', 'active');
                                },
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn ($record): string =>
                                    "{$record->name} — {$record->email}"
                            )
                            ->searchable([
                                'name',
                                'email',
                            ])
                            ->preload()
                            ->required()
                            ->helperText(
                                'The Platform Owner cannot receive delegated authority.'
                            ),

                        Select::make('organization_id')
                            ->label('Organization')
                            ->relationship(
                                'organization',
                                'name',
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText(
                                'Leave empty for platform-level delegation.'
                            ),

                        Select::make('parent_delegation_id')
                            ->label('Parent Delegation')
                            ->relationship(
                                'parentDelegation',
                                'id',
                                modifyQueryUsing: fn ($query) => $query
                                    ->where('delegated_to_user_id', Auth::id())
                                    ->where('status', 'active')
                                    ->whereNull('revoked_at'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (SecurityDelegation $record): string =>
                                    "#{$record->id} — {$record->delegatedToUser?->name}"
                            )
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText(
                                'Use this when the delegation is derived from another delegation.'
                            ),

                    ])
                    ->columns(2),

                Section::make('Permissions')
                    ->description(
                        'Select the permissions granted by this delegation.'
                    )
                    ->schema([

                        Select::make('permissions')
                            ->label('Granted Permissions')
                            ->relationship(
                                'permissions',
                                'name',
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->helperText(
                                'Only existing system permissions can be delegated.'
                            )
                            ->columnSpanFull(),

                    ]),

                Section::make('Validity & Status')
                    ->description(
                        'Control when the delegated authority becomes active and when it ends.'
                    )
                    ->schema([

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'pending' => 'Pending',
                            ])
                            ->default('active')
                            ->required()
                            ->helperText('Pending delegations grant no access until activated.'),

                        DateTimePicker::make('starts_at')
                            ->label('Starts At')
                            ->native(false)
                            ->nullable(),

                        DateTimePicker::make('expires_at')
                            ->label('Expires At')
                            ->native(false)
                            ->nullable()
                            ->afterOrEqual('starts_at'),

                    ])
                    ->columns(2),

                Section::make('Reason')
                    ->description(
                        'Record why this delegation was created.'
                    )
                    ->schema([

                        Textarea::make('reason')
                            ->label('Delegation Reason')
                            ->rows(4)
                            ->maxLength(5000)
                            ->nullable()
                            ->columnSpanFull(),

                    ]),

            ]);
    }
}
