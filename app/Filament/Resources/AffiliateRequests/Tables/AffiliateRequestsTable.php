<?php

namespace App\Filament\Resources\AffiliateRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AffiliateRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Request Date'),
                TextColumn::make('affiliate.user.name')
                    ->label('Affiliate Name')
                    ->searchable(),
                TextColumn::make('affiliate.referral_code')
                    ->label('Ref Code')
                    ->searchable(),
                TextColumn::make('merchant.company_name')
                    ->label('Merchant')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Not yet reviewed'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->recordActions([
                Action::make('approve')
                    ->action(fn($record) => $record->update([
                        'status' => 'approved',
                        'reviewed_at' => now(),
                    ]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn($record) => $record->status === 'pending'),
                Action::make('reject')
                    ->action(fn($record) => $record->update([
                        'status' => 'rejected',
                        'reviewed_at' => now(),
                    ]))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn($record) => $record->status === 'pending'),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
