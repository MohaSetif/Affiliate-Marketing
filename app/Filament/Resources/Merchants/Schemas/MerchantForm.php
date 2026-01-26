<?php

namespace App\Filament\Resources\Merchants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MerchantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Merchant Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->searchable(),
                                TextInput::make('company_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->required(),
                                TextInput::make('whatsapp')
                                    ->tel(),
                                DateTimePicker::make('approved_at')
                                    ->disabled()
                                    ->placeholder('Not yet approved'),
                            ]),
                    ]),
            ]);
    }
}
