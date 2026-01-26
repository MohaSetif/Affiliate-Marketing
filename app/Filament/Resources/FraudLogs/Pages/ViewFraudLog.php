<?php

namespace App\Filament\Resources\FraudLogs\Pages;

use App\Filament\Resources\FraudLogs\FraudLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFraudLog extends ViewRecord
{
    protected static string $resource = FraudLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
