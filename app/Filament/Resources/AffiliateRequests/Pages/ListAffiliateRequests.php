<?php

namespace App\Filament\Resources\AffiliateRequests\Pages;

use App\Filament\Resources\AffiliateRequests\AffiliateRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAffiliateRequests extends ListRecords
{
    protected static string $resource = AffiliateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
