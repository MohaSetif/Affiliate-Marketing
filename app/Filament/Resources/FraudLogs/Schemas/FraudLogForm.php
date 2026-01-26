<?php

namespace App\Filament\Resources\FraudLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FraudLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->numeric(),
                TextInput::make('affiliate_id')
                    ->numeric(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('reason')
                    ->required(),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                Textarea::make('payload')
                    ->columnSpanFull(),
            ]);
    }
}
