<?php

namespace App\Filament\Resources\Memberships\Tables;

use App\Filament\Resources\Memberships\MembershipResource;
use App\Models\Membership;
use App\Services\OrganizationInvitationService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembershipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('user.avatar')
                    ->label('Profile')
                    ->getStateUsing(fn (Membership $record): ?string => $record->user?->getFilamentAvatarUrl())
                    ->circular()
                    ->toggleable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->state(fn (Membership $record): ?string => $record->user?->name ?? $record->invite_email)
                    ->placeholder('Pending invitation')
                    ->weight('medium'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('invite_email')
                    ->label('Invited Email')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'owner' => 'Owner',
                        'admin' => 'Administrator',
                        'member' => 'Member',
                        'viewer' => 'Viewer',
                        default => str($state)->replace('_', ' ')->title(),
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'suspended' => 'danger',
                        'invited' => 'warning',
                        'revoked' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('joined_at')
                    ->label('Joined At')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('invitation_expires_at')
                    ->label('Invitation Expires')
                    ->dateTime()
                    ->placeholder('—')
                    ->color(fn (Membership $record): ?string => $record->status === 'invited'
                        && $record->invitation_expires_at?->isPast()
                        ? 'danger'
                        : null)
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                SelectFilter::make('organization_id')
                    ->label('Organization')
                    ->relationship(
                        'organization',
                        'name'
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                        'invited' => 'Invited',
                        'revoked' => 'Revoked',
                    ]),

                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'owner' => 'Owner',
                        'admin' => 'Administrator',
                        'member' => 'Member',
                        'viewer' => 'Viewer',
                    ]),

            ])

            ->recordActions([
                Action::make('profile')
                    ->label('Profile')
                    ->icon('heroicon-o-identification')
                    ->url(fn (Membership $record): string => MembershipResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
                Action::make('resendInvitation')
                    ->label('Resend invitation')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Membership $record): bool => $record->status === 'invited')
                    ->action(
                        fn (Membership $record) => app(OrganizationInvitationService::class)->send($record)
                    ),
                Action::make('reinvite')
                    ->label('Send invitation again')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (Membership $record): bool => $record->status === 'revoked'
                        && filled($record->invite_email))
                    ->action(
                        fn (Membership $record) => app(OrganizationInvitationService::class)->reinvite($record)
                    ),
                Action::make('revokeInvitation')
                    ->label('Revoke invitation')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Membership $record): bool => $record->status === 'invited')
                    ->action(fn (Membership $record) => app(OrganizationInvitationService::class)->revoke($record)),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}