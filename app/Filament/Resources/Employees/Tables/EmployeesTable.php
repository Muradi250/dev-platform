<?php

namespace App\Filament\Resources\Employees\Tables;

use App\Filament\Resources\Employees\EmployeeResource;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->disk('public')
                    ->circular()
                    ->toggleable(),

                TextColumn::make('employee_number')
                    ->label('Employee No.')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('full_name')
                    ->label('Employee')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name'])
                    ->weight('medium'),

                TextColumn::make('job_title')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('organization.name')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('organizationalUnit.name')
                    ->label('Unit')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('work_email')
                    ->label('Work Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('employment_type')
                    ->label('Employment')
                    ->badge()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'suspended' => 'warning',
                        'terminated' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('joined_at')
                    ->label('Joined')
                    ->date()
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('organization_id')
                    ->label('Organization')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('organizational_unit_id')
                    ->label('Unit')
                    ->relationship('organizationalUnit', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'suspended' => 'Suspended',
                        'terminated' => 'Terminated',
                    ]),

                SelectFilter::make('employment_type')
                    ->label('Employment Type')
                    ->options([
                        'full_time' => 'Full Time',
                        'part_time' => 'Part Time',
                        'contract' => 'Contract',
                        'temporary' => 'Temporary',
                        'intern' => 'Intern',
                        'volunteer' => 'Volunteer',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                Action::make('profile')
                    ->label('Profile')
                    ->url(fn (Employee $record): string => EmployeeResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
