<?php

namespace App\Filament\Resources\FraudLogs\Pages;

use App\Filament\Resources\FraudLogs\FraudLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFraudLog extends EditRecord
{
    protected static string $resource = FraudLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
