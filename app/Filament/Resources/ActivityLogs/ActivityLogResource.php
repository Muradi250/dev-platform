<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLogs\Pages\ViewActivityLog;
use App\Filament\Resources\ActivityLogs\Schemas\ActivityLogInfolist;
use App\Models\ActivityLog;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static UnitEnum|string|null $navigationGroup = 'Security & Audit';

    protected static ?string $navigationLabel = 'Activity Log';

    protected static ?int $navigationSort = 90;

    protected static ?string $recordTitleAttribute = 'action';

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function infolist(Schema $schema): Schema
    {
        return ActivityLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->default('System / deleted user')
                    ->searchable(),

                TextColumn::make('action')
                    ->label('Action')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->placeholder('Legacy')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('module')
                    ->label('Module')
                    ->badge()
                    ->placeholder('Legacy')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('severity')
                    ->label('Severity')
                    ->badge()
                    ->placeholder('info')
                    ->color(fn (?string $state): string => match ($state) {
                        'danger', 'critical' => 'danger',
                        'warning' => 'warning',
                        'success' => 'success',
                        'info' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(90)
                    ->wrap()
                    ->searchable()
                    ->tooltip(fn (ActivityLog $record): ?string =>
                        $record->description
                    ),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(),

                TextColumn::make('model_type')
                    ->label('Subject Type')
                    ->limit(35)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('model_id')
                    ->label('Subject ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'security' => 'Security',
                        'users' => 'Users',
                        'access' => 'Access',
                        'organization' => 'Organization',
                        'system' => 'System',
                    ]),

                SelectFilter::make('severity')
                    ->options([
                        'info' => 'Info',
                        'success' => 'Success',
                        'warning' => 'Warning',
                        'danger' => 'Danger',
                        'critical' => 'Critical',
                    ]),

                SelectFilter::make('module')
                    ->options(fn (): array => ActivityLog::query()
                        ->whereNotNull('module')
                        ->distinct()
                        ->orderBy('module')
                        ->pluck('module', 'module')
                        ->all()),

                SelectFilter::make('action')
                    ->options(fn (): array => ActivityLog::query()
                        ->whereNotNull('action')
                        ->distinct()
                        ->orderBy('action')
                        ->pluck('action', 'action')
                        ->all()),

                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
            'view' => ViewActivityLog::route('/{record}'),
        ];
    }
}