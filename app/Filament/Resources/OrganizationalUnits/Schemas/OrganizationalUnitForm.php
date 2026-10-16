<?php

namespace App\Filament\Resources\OrganizationalUnits\Schemas;

use App\Models\OrganizationalUnit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class OrganizationalUnitForm
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
                    ->description('Select the organization this unit belongs to.')
                    ->schema([
                        Select::make('organization_id')
                            ->label('Organization')
                            ->relationship('organization', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->disabled(fn (string $operation): bool => $operation !== 'create')
                            ->afterStateUpdated(fn (Set $set) => $set('parent_id', null))
                            ->required(),
                    ])
                    ->columns(1),

                /*
                |--------------------------------------------------------------------------
                | Unit Identity
                |--------------------------------------------------------------------------
                */

                Section::make('Unit Identity')
                    ->description('Basic identity and classification of the organizational unit.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Unit Name')
                            ->placeholder('e.g. Finance Department')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('code')
                            ->label('Unit Code')
                            ->placeholder('e.g. FIN')
                            ->required()
                            ->alphaDash()
                            ->maxLength(50)
                            ->unique(
                                ignoreRecord: true,
                                modifyRuleUsing: fn ($rule, Get $get) => $rule->where(
                                    'organization_id',
                                    $get('organization_id')
                                )
                            ),

                        Select::make('type')
                            ->label('Unit Type')
                            ->options([
                                'department' => 'Department',
                                'division' => 'Division',
                                'team' => 'Team',
                                'branch' => 'Branch',
                                'section' => 'Section',
                                'office' => 'Office',
                                'other' => 'Other',
                            ])
                            ->default('department')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                            ])
                            ->default('active')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Unit Leadership & Location')
                    ->description('Optional contact and operational details for this unit.')
                    ->schema([
                        TextInput::make('head_name')
                            ->label('Unit Head')
                            ->maxLength(255),

                        TextInput::make('head_email')
                            ->label('Head Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('head_phone')
                            ->label('Head Phone')
                            ->tel()
                            ->maxLength(50),

                        TextInput::make('location')
                            ->label('Office / Location')
                            ->maxLength(255),

                        DatePicker::make('effective_from')
                            ->label('Effective From')
                            ->native(false),

                        DatePicker::make('effective_until')
                            ->label('Effective Until')
                            ->native(false)
                            ->afterOrEqual('effective_from'),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Parent Unit
                |--------------------------------------------------------------------------
                */

                Section::make('Organizational Structure')
                    ->description('Optionally place this unit under another organizational unit.')
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent Unit')
                            ->relationship(
                                'parent',
                                'name',
                                modifyQueryUsing: function ($query, Get $get, ?OrganizationalUnit $record) {
                                    $organizationId = $get('organization_id');

                                    if ($organizationId) {
                                        $query->where('organization_id', $organizationId);
                                    } else {
                                        $query->whereRaw('1 = 0');
                                    }

                                    if ($record?->exists) {
                                        $query->whereNotIn('id', $record->descendantIds(includeSelf: true));
                                    }
                                },
                                ignoreRecord: true,
                            )
                            ->searchable()
                            ->helperText('Only units in the same organization can be selected. Descendants are excluded to prevent circular reporting lines.')
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
