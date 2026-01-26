<?php

namespace App\Filament\Resources\AffiliateRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class AffiliateRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Request Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('affiliate_id')
                                    ->relationship('affiliate', 'referral_code')
                                    ->required()
                                    ->searchable(),
                                Select::make('merchant_id')
                                    ->relationship('merchant', 'company_name')
                                    ->required()
                                    ->searchable(),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required()
                                    ->default('pending'),
                                DateTimePicker::make('reviewed_at')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }
}
