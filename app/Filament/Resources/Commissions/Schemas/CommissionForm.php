<?php

namespace App\Filament\Resources\Commissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('affiliate_id')
                    ->relationship('affiliate', 'id')
                    ->required(),
                Select::make('lead_id')
                    ->relationship('lead', 'id')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'title')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('paid_at'),
            ]);
    }
}
