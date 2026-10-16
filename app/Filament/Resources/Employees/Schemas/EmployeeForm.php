<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Organization
                |--------------------------------------------------------------------------
                */

                Section::make('Organization')
                    ->description('Select the organization and organizational unit for this employee.')
                    ->schema([
                        Select::make('organization_id')
                            ->label('Organization')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('organizational_unit_id', null))
                            ->required(),

                        Select::make('organizational_unit_id')
                            ->label('Organizational Unit')
                            ->relationship(
                                'organizationalUnit',
                                'name',
                                modifyQueryUsing: function ($query, Get $get) {
                                    $organizationId = $get('organization_id');

                                    if ($organizationId) {
                                        $query->where(
                                            'organization_id',
                                            $organizationId
                                        );
                                    } else {
                                        $query->whereRaw('1 = 0');
                                    }
                                },
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Employee Identity
                |--------------------------------------------------------------------------
                */

                Section::make('Employee Identity')
                    ->description('Basic identification information for the employee.')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Profile Photo')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('employees/photos')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->avatar()
                            ->columnSpanFull(),

                        TextInput::make('employee_number')
                            ->label('Employee Number')
                            ->required()
                            ->maxLength(50)
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: function ($rule, Get $get) {
                                    return $rule->where(
                                        'organization_id',
                                        $get('organization_id')
                                    );
                                }
                            ),

                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Contact Information')
                    ->description('Work contact details and optional emergency contact.')
                    ->schema([
                        TextInput::make('work_email')
                            ->label('Work Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(50),

                        TextInput::make('emergency_contact_name')
                            ->label('Emergency Contact')
                            ->maxLength(255),

                        TextInput::make('emergency_contact_phone')
                            ->label('Emergency Phone')
                            ->tel()
                            ->maxLength(50),

                        Select::make('emergency_contact_relationship')
                            ->label('Relationship')
                            ->options([
                                'spouse' => 'Spouse',
                                'parent' => 'Parent',
                                'sibling' => 'Sibling',
                                'child' => 'Child',
                                'relative' => 'Other relative',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->nullable(),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Employment
                |--------------------------------------------------------------------------
                */

                Section::make('Employment')
                    ->description('Employment status, position, type, and dates.')
                    ->schema([
                        TextInput::make('job_title')
                            ->label('Job Title')
                            ->maxLength(255),

                        Select::make('employment_type')
                            ->label('Employment Type')
                            ->options([
                                'full_time' => 'Full Time',
                                'part_time' => 'Part Time',
                                'contract' => 'Contract',
                                'temporary' => 'Temporary',
                                'intern' => 'Intern',
                                'volunteer' => 'Volunteer',
                                'other' => 'Other',
                            ])
                            ->default('full_time')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                                'terminated' => 'Terminated',
                            ])
                            ->default('active')
                            ->required(),

                        DatePicker::make('joined_at')
                            ->label('Joined Date')
                            ->native(false),

                        DatePicker::make('ended_at')
                            ->label('Ended Date')
                            ->native(false),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | User Account
                |--------------------------------------------------------------------------
                */

                Section::make('User Account')
                    ->description('Optionally connect this employee to an existing system user account.')
                    ->schema([
                        Select::make('user_id')
                            ->label('User Account')
                            ->relationship(
                                'user',
                                'name',
                                modifyQueryUsing: function ($query, \Filament\Forms\Components\Select $component) {
                                    $record = $component->getRecord();

                                    $query->whereNotIn(
                                        $query->getModel()->qualifyColumn('id'),
                                        \App\Models\Employee::query()
                                            ->whereNotNull('user_id')
                                            ->when(
                                                $record instanceof \App\Models\Employee,
                                                fn ($employees) => $employees->whereKeyNot($record->getKey())
                                            )
                                            ->select('user_id')
                                    );
                                },
                            )
                            ->searchable()
                            ->getOptionLabelFromRecordUsing(
                                fn ($record): string => "{$record->name} — {$record->email}"
                            )
                            ->nullable(),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
