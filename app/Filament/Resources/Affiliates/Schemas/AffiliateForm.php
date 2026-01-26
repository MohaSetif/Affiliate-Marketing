<?php

namespace App\Filament\Resources\Affiliates\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AffiliateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Affiliate Profile')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable(),
                                TextInput::make('referral_code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20),
                            ]),
                    ]),
            ]);
    }
}
