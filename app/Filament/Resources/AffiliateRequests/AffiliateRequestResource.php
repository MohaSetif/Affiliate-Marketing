<?php

namespace App\Filament\Resources\AffiliateRequests;

use App\Filament\Resources\AffiliateRequests\Pages\CreateAffiliateRequest;
use App\Filament\Resources\AffiliateRequests\Pages\EditAffiliateRequest;
use App\Filament\Resources\AffiliateRequests\Pages\ListAffiliateRequests;
use App\Filament\Resources\AffiliateRequests\Pages\ViewAffiliateRequest;
use App\Filament\Resources\AffiliateRequests\Schemas\AffiliateRequestForm;
use App\Filament\Resources\AffiliateRequests\Schemas\AffiliateRequestInfolist;
use App\Filament\Resources\AffiliateRequests\Tables\AffiliateRequestsTable;
use App\Models\AffiliateRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AffiliateRequestResource extends Resource
{
    protected static ?string $model = AffiliateRequest::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-hand-raised';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return AffiliateRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AffiliateRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AffiliateRequestsTable::configure($table);
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
            'index' => ListAffiliateRequests::route('/'),
            'create' => CreateAffiliateRequest::route('/create'),
            'view' => ViewAffiliateRequest::route('/{record}'),
            'edit' => EditAffiliateRequest::route('/{record}/edit'),
        ];
    }
}
