<?php

namespace App\Filament\Resources\FraudLogs\Pages;

use App\Filament\Resources\FraudLogs\FraudLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFraudLogs extends ListRecords
{
    protected static string $resource = FraudLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
