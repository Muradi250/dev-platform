<?php

namespace App\Filament\Resources\Organizations\Schemas;

use DateTimeZone;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Identity
                |--------------------------------------------------------------------------
                */

                Section::make('Identity')
                    ->description('Basic identity and classification of the organization.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Organization Name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('code')
                            ->label('Organization Code')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Select::make('type')
                            ->label('Organization Type')
                            ->options([
                                'organization' => 'Organization',
                                'company' => 'Company',
                                'ngo' => 'NGO',
                                'government' => 'Government',
                                'other' => 'Other',
                            ])
                            ->default('organization')
                            ->required(),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Organization Status
                |--------------------------------------------------------------------------
                */

                Section::make('Organization Status')
                    ->description('Control the current operational status of the organization.')
                    ->schema([
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

                Section::make('Legal Information')
                    ->description('Legal registration and tax identifiers.')
                    ->schema([
                        Select::make('legal_type')
                            ->label('Legal Entity Type')
                            ->options([
                                'sole_proprietorship' => 'Sole proprietorship',
                                'partnership' => 'Partnership',
                                'corporation' => 'Corporation',
                                'nonprofit' => 'Non-profit',
                                'government' => 'Government entity',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->nullable(),

                        TextInput::make('registration_number')
                            ->label('Registration Number')
                            ->maxLength(100),

                        TextInput::make('tax_id')
                            ->label('Tax ID')
                            ->maxLength(100),
                    ])
                    ->columns(2),

                Section::make('Address')
                    ->schema([
                        TextInput::make('address_line_1')
                            ->label('Address Line 1')
                            ->maxLength(255),

                        TextInput::make('address_line_2')
                            ->label('Address Line 2')
                            ->maxLength(255),

                        TextInput::make('country')
                            ->label('Country')
                            ->maxLength(100),

                        TextInput::make('region')
                            ->label('State / Province / Region')
                            ->maxLength(100),

                        TextInput::make('city')
                            ->label('City')
                            ->maxLength(100),

                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->maxLength(30),
                    ])
                    ->columns(2),

                Section::make('Primary Contact')
                    ->schema([
                        TextInput::make('primary_contact_name')
                            ->label('Contact Name')
                            ->maxLength(255),

                        TextInput::make('primary_contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('primary_contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(50),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Localization
                |--------------------------------------------------------------------------
                */

                Section::make('Localization')
                    ->description('Default language used by this organization.')
                    ->schema([
                        Select::make('default_locale')
                            ->label('Default Locale')
                            ->options([
                                'en' => 'English',
                                'fa' => 'Persian',
                                'ps' => 'Pashto',
                            ])
                            ->default('en')
                            ->required(),

                        Select::make('timezone')
                            ->label('Time Zone')
                            ->options(array_combine(
                                DateTimeZone::listIdentifiers(),
                                DateTimeZone::listIdentifiers(),
                            ))
                            ->searchable()
                            ->default('UTC')
                            ->required(),

                        TextInput::make('currency')
                            ->label('Currency')
                            ->length(3)
                            ->regex('/^[A-Za-z]{3}$/')
                            ->dehydrateStateUsing(fn (?string $state): string => strtoupper((string) $state))
                            ->default('USD')
                            ->helperText('Enter an ISO 4217 currency code, such as USD or AFN.')
                            ->required(),
                    ])
                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | Contact Information
                |--------------------------------------------------------------------------
                */

                Section::make('Contact Information')
                    ->description('Primary contact information for the organization.')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(50),

                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),
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

                /*
                |--------------------------------------------------------------------------
                | Branding
                |--------------------------------------------------------------------------
                */

                Section::make('Branding')
                    ->description('Organization branding information.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Organization Logo')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->directory('organizations/logos')
                            ->maxSize(2048)
                            ->nullable(),
                    ])
                    ->columns(2),

            ]);
    }
}
