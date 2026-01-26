<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('title'),
                                TextEntry::make('merchant.company_name')
                                    ->label('Merchant'),
                            ]),
                        ImageEntry::make('image')
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->html()
                            ->columnSpanFull(),
                    ]),
                Section::make('Commission Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('commission_type')
                                    ->badge(),
                                TextEntry::make('commission_value')
                                    ->label('Value')
                                    ->formatStateUsing(fn ($state, $record) => $record->commission_type === 'fixed' ? "DZD {$state}" : "{$state}%"),
                                IconEntry::make('is_active')
                                    ->boolean()
                                    ->label('Active'),
                            ]),
                    ]),
            ]);
    }
}
