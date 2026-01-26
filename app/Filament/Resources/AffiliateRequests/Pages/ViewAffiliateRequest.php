<?php

namespace App\Filament\Resources\AffiliateRequests\Pages;

use App\Filament\Resources\AffiliateRequests\AffiliateRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAffiliateRequest extends ViewRecord
{
    protected static string $resource = AffiliateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
