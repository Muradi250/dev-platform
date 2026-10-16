<?php

namespace App\Filament\Resources\SecurityDelegations;

use App\Filament\Resources\SecurityDelegations\Pages\CreateSecurityDelegation;
use App\Filament\Resources\SecurityDelegations\Pages\EditSecurityDelegation;
use App\Filament\Resources\SecurityDelegations\Pages\ListSecurityDelegations;
use App\Filament\Resources\SecurityDelegations\Pages\ViewSecurityDelegation;
use App\Filament\Resources\SecurityDelegations\Schemas\SecurityDelegationForm;
use App\Filament\Resources\SecurityDelegations\Schemas\SecurityDelegationInfolist;
use App\Filament\Resources\SecurityDelegations\Tables\SecurityDelegationsTable;
use App\Models\SecurityDelegation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SecurityDelegationResource extends Resource
{
    protected static ?string $model = SecurityDelegation::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Delegations';

    protected static UnitEnum|string|null $navigationGroup =
        'Access & Security';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return SecurityDelegationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SecurityDelegationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SecurityDelegationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSecurityDelegations::route('/'),
            'create' => CreateSecurityDelegation::route('/create'),
            'view' => ViewSecurityDelegation::route('/{record}'),
            'edit' => EditSecurityDelegation::route('/{record}/edit'),
        ];
    }
}

