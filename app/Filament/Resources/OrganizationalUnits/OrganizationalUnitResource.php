<?php

namespace App\Filament\Resources\OrganizationalUnits;

use App\Filament\Resources\OrganizationalUnits\Pages\CreateOrganizationalUnit;
use App\Filament\Resources\OrganizationalUnits\Pages\EditOrganizationalUnit;
use App\Filament\Resources\OrganizationalUnits\Pages\ListOrganizationalUnits;
use App\Filament\Resources\OrganizationalUnits\Pages\ViewOrganizationalUnit;
use App\Filament\Resources\OrganizationalUnits\Schemas\OrganizationalUnitForm;
use App\Filament\Resources\OrganizationalUnits\Tables\OrganizationalUnitsTable;
use App\Models\OrganizationalUnit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class OrganizationalUnitResource extends Resource
{
    protected static ?string $model = OrganizationalUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static UnitEnum|string|null $navigationGroup = 'Organization';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationalUnitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationalUnitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationalUnits::route('/'),
            'create' => CreateOrganizationalUnit::route('/create'),
            'view' => ViewOrganizationalUnit::route('/{record}'),
            'edit' => EditOrganizationalUnit::route('/{record}/edit'),
        ];
    }
}
