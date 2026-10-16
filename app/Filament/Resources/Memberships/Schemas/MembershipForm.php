<?php

namespace App\Filament\Resources\Memberships\Schemas;

use App\Models\Membership;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class MembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Membership')
                    ->description('Add an existing user or invite someone by email.')
                    ->schema([

                        Select::make('organization_id')
                            ->label('Organization')
                            ->relationship(
                                'organization',
                                'name',
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->disabled(fn (string $operation): bool => $operation !== 'create')
                            ->afterStateUpdated(function (Set $set): void {
                                $set('user_id', null);
                                $set('invite_email', null);
                            })
                            ->required(),

                        TextInput::make('invite_email')
                            ->label('Invite by Email')
                            ->email()
                            ->trim()
                            ->dehydrateStateUsing(
                                fn (?string $state): ?string => filled($state)
                                    ? strtolower(trim($state))
                                    : null
                            )
                            ->maxLength(255)
                            ->nullable()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set) => $set('user_id', null))
                            ->visible(fn (Get $get, string $operation): bool => $operation === 'create'
                                && filled($get('organization_id')))
                            ->rules(fn (Get $get): array => filled($get('organization_id'))
                                ? [
                                    function (string $attribute, mixed $value, \Closure $fail) use ($get): void {
                                        if (blank($value)) {
                                            return;
                                        }

                                        $email = strtolower(trim((string) $value));
                                        $organizationId = $get('organization_id');

                                        $pendingInvitationExists = Membership::query()
                                            ->where('organization_id', $organizationId)
                                            ->whereRaw('LOWER(invite_email) = ?', [$email])
                                            ->exists();

                                        if ($pendingInvitationExists) {
                                            $fail('An invitation for this email already exists in this organization.');

                                            return;
                                        }

                                        $alreadyMember = Membership::query()
                                            ->where('organization_id', $organizationId)
                                            ->whereHas(
                                                'user',
                                                fn ($query) => $query->whereRaw(
                                                    'LOWER(email) = ?',
                                                    [strtolower((string) $value)]
                                                )
                                            )
                                            ->exists();

                                        if ($alreadyMember) {
                                            $fail('This user is already a member. Select the existing user instead.');
                                        }
                                    },
                                ]
                                : [])
                            ->required(fn (Get $get): bool => filled($get('organization_id'))
                                && blank($get('user_id')))
                            ->helperText('An invitation link will be emailed. It expires after seven days.'),

                        Select::make('user_id')
                            ->label('User')
                            ->relationship(
                                'user',
                                'name',
                                modifyQueryUsing: function ($query, Get $get, ?Membership $record) {
                                    $organizationId = $get('organization_id');

                                    if ($organizationId) {
                                        $query->whereNotIn(
                                            $query->getModel()->qualifyColumn('id'),
                                            Membership::query()
                                                ->where('organization_id', $organizationId)
                                                ->whereNotNull('user_id')
                                                ->when(
                                                    $record,
                                                    fn ($memberships) => $memberships->whereKeyNot($record->getKey())
                                                )
                                                ->select('user_id')
                                        );
                                    }
                                },
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn ($record): string => "{$record->name} — {$record->email}"
                            )
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('invite_email', null))
                            ->visible(fn (
                                Get $get,
                                string $operation,
                                ?Membership $record,
                            ): bool => $operation === 'create'
                                ? filled($get('organization_id'))
                                : ! in_array($record?->status, ['invited', 'revoked'], true))
                            ->searchable([
                                'name',
                                'email',
                            ])
                            ->required(fn (Get $get): bool => filled($get('organization_id'))
                                && blank($get('invite_email'))),

                        Select::make('role')
                            ->label('Organization Role')
                            ->options([
                                'owner' => 'Owner',
                                'admin' => 'Administrator',
                                'member' => 'Member',
                                'viewer' => 'Viewer',
                            ])
                            ->default('member')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                            ])
                            ->default('active')
                            ->visible(fn (string $operation, ?Membership $record): bool => $operation !== 'create'
                                && ! in_array($record?->status, ['invited', 'revoked'], true))
                            ->required(),

                        DateTimePicker::make('joined_at')
                            ->label('Joined At')
                            ->native(false)
                            ->nullable()
                            ->visible(fn (string $operation): bool => $operation !== 'create'),

                    ])
                    ->columns(2),
            ]);
    }
}