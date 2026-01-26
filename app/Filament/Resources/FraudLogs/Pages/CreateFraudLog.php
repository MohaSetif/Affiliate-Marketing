<?php

namespace App\Filament\Resources\FraudLogs\Pages;

use App\Filament\Resources\FraudLogs\FraudLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFraudLog extends CreateRecord
{
    protected static string $resource = FraudLogResource::class;
}
