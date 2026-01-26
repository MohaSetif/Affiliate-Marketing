<?php

namespace App\Filament\Resources\AffiliateRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Schemas\Schema;

class AffiliateRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Partnership Request')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('affiliate.user.name')
                                    ->label('Affiliate Name'),
                                TextEntry::make('affiliate.referral_code')
                                    ->label('Referral Code'),
                                TextEntry::make('merchant.company_name')
                                    ->label('Merchant Company'),
                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                    }),
                            ]),
                    ]),
                Section::make('Audit Trail')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->dateTime()
                                    ->label('Requested On'),
                                TextEntry::make('reviewed_at')
                                    ->dateTime()
                                    ->label('Reviewed On')
                                    ->placeholder('Not yet reviewed'),
                                TextEntry::make('updated_at')
                                    ->dateTime()
                                    ->label('Last Updated'),
                            ]),
                    ]),
            ]);
    }
}
