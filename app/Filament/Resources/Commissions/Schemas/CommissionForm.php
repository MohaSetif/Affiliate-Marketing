<?php

namespace App\Filament\Resources\Commissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Commission Record')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('affiliate_id')
                                    ->relationship('affiliate', 'referral_code')
                                    ->required()
                                    ->searchable(),
                                Select::make('lead_id')
                                    ->relationship('lead', 'id')
                                    ->required()
                                    ->searchable(),
                                Select::make('product_id')
                                    ->relationship('product', 'title')
                                    ->required()
                                    ->searchable(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('DZD'),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->default('pending'),
                            ]),
                        DateTimePicker::make('paid_at')
                            ->disabled()
                            ->placeholder('Sets automatically when withdrawal is processed'),
                    ]),
            ]);
    }
}
