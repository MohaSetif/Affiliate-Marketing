<?php

namespace App\Filament\Resources\FraudLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class FraudLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Fraud Attempt Details')
                    ->description('Audit logs are read-only.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'title')
                                    ->disabled(),
                                Select::make('affiliate_id')
                                    ->relationship('affiliate', 'referral_code')
                                    ->disabled(),
                                TextInput::make('phone')
                                    ->disabled(),
                            ]),
                        TextInput::make('reason')
                            ->columnSpanFull()
                            ->disabled(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('ip_address')
                                    ->disabled(),
                                Textarea::make('user_agent')
                                    ->disabled(),
                            ]),
                        Textarea::make('payload')
                            ->columnSpanFull()
                            ->disabled()
                            ->formatStateUsing(fn($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT) : $state),
                    ]),
            ]);
    }
}
