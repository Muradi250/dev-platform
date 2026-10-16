<?php

namespace App\Filament\Resources\OrganizationalUnits\Tables;

use App\Filament\Resources\OrganizationalUnits\OrganizationalUnitResource;
use App\Models\OrganizationalUnit;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrganizationalUnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Unit')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.name')
                    ->label('Parent Unit')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Root unit'),

                TextColumn::make('children_count')
                    ->label('Child Units')
                    ->counts('children')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('employees_count')
                    ->label('Employees')
                    ->counts('employees')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str($state)->replace('_', ' ')->title())
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'suspended' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('head_name')
                    ->label('Unit Head')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('effective_from')
                    ->label('Effective from')
                    ->date()
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('organization_id')
                    ->label('Organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'department' => 'Department',
                        'division' => 'Division',
                        'team' => 'Team',
                        'branch' => 'Branch',
                        'section' => 'Section',
                        'office' => 'Office',
                        'other' => 'Other',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                    ]),

                TernaryFilter::make('parent_id')
                    ->label('Hierarchy level')
                    ->placeholder('All units')
                    ->trueLabel('Child units')
                    ->falseLabel('Root units')
                    ->nullable(),
            ])
            ->recordActions([
                Action::make('profile')
                    ->label('Profile')
                    ->icon('heroicon-o-identification')
                    ->url(fn (OrganizationalUnit $record): string => OrganizationalUnitResource::getUrl('view', ['record' => $record])),

                EditAction::make(),

                DeleteAction::make()
                    ->visible(fn (OrganizationalUnit $record): bool => ! $record->children()->exists()
                        && ! $record->employees()->exists()),
            ]);
    }
}
