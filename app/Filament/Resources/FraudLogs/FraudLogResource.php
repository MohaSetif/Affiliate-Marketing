<?php

namespace App\Filament\Resources\FraudLogs;

use App\Filament\Resources\FraudLogs\Pages\CreateFraudLog;
use App\Filament\Resources\FraudLogs\Pages\EditFraudLog;
use App\Filament\Resources\FraudLogs\Pages\ListFraudLogs;
use App\Filament\Resources\FraudLogs\Pages\ViewFraudLog;
use App\Filament\Resources\FraudLogs\Schemas\FraudLogForm;
use App\Filament\Resources\FraudLogs\Schemas\FraudLogInfolist;
use App\Filament\Resources\FraudLogs\Tables\FraudLogsTable;
use App\Models\FraudLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FraudLogResource extends Resource
{
    protected static ?string $model = FraudLog::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';

    protected static string | \UnitEnum | null $navigationGroup = 'System';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'reason';

    public static function form(Schema $schema): Schema
    {
        return FraudLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FraudLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FraudLogsTable::configure($table);
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
            'index' => ListFraudLogs::route('/'),
            'create' => CreateFraudLog::route('/create'),
            'view' => ViewFraudLog::route('/{record}'),
            'edit' => EditFraudLog::route('/{record}/edit'),
        ];
    }
}
