<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lead Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('product.title'),
                                TextEntry::make('affiliate.referral_code')
                                    ->label('Affiliate')
                                    ->placeholder('Direct'),
                                TextEntry::make('customer_name'),
                                TextEntry::make('phone'),
                            ]),
                    ]),
                Section::make('Transaction & Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_value')
                                    ->money('DZD'),
                                TextEntry::make('source'),
                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                    }),
                            ]),
                        TextEntry::make('notes')
                            ->columnSpanFull(),
                    ]),
                Section::make('Auditing')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->label('Created At'),
                                TextEntry::make('approved_at')
                                    ->dateTime()
                                    ->label('Approved At'),
                                TextEntry::make('rejected_at')
                                    ->dateTime()
                                    ->label('Rejected At'),
                            ]),
                    ]),
            ]);
    }
}
