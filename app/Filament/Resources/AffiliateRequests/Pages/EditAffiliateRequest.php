<?php

namespace App\Filament\Resources\AffiliateRequests\Pages;

use App\Filament\Resources\AffiliateRequests\AffiliateRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAffiliateRequest extends EditRecord
{
    protected static string $resource = AffiliateRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
