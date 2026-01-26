<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'title')
                                    ->required()
                                    ->searchable(),
                                Select::make('affiliate_id')
                                    ->relationship('affiliate', 'referral_code')
                                    ->searchable()
                                    ->placeholder('None (Direct)'),
                                TextInput::make('customer_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->required()
                                    ->tel(),
                            ]),
                    ]),
                Section::make('Transaction Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('order_value')
                                    ->numeric()
                                    ->prefix('DZD'),
                                Select::make('source')
                                    ->options([
                                        'call' => 'Phone Call',
                                        'whatsapp' => 'WhatsApp',
                                        'form' => 'Online Form',
                                    ])
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required(),
                            ]),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
                Section::make('Audit')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('approved_at')
                                    ->disabled(),
                                DateTimePicker::make('rejected_at')
                                    ->disabled(),
                            ]),
                    ])
                    ->collapsed(),
            ]);
    }
}
