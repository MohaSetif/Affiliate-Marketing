<?php

namespace App\Filament\Resources\AffiliateRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AffiliateRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('affiliate_id')
                    ->relationship('affiliate', 'id')
                    ->required(),
                Select::make('merchant_id')
                    ->relationship('merchant', 'id')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('reviewed_at'),
            ]);
    }
}
