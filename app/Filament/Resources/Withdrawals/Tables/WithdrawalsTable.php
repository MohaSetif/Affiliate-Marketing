<?php

namespace App\Filament\Resources\Withdrawals\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class WithdrawalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Requested At')
                    ->sortable(),
                TextColumn::make('affiliate.user.name')
                    ->label('Affiliate')
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('DZD')
                    ->sortable(),
                TextColumn::make('method')
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'info',
                        'paid' => 'success',
                        'rejected' => 'danger',
                    }),
                TextColumn::make('processed_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Pending'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'paid' => 'Paid',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('method')
                    ->options([
                        'cash' => 'Cash',
                        'ccp' => 'CCP',
                        'baridimob' => 'BaridiMob',
                        'bank' => 'Bank',
                    ]),
            ])
            ->recordActions([
                Action::make('mark_paid')
                    ->label('Mark as Paid')
                    ->action(fn($record) => $record->update([
                        'status' => 'paid',
                        'processed_at' => now(),
                    ]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-currency-dollar')
                    ->visible(fn($record) => $record->status === 'approved' || $record->status === 'pending'), // Usually Admin decides
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
