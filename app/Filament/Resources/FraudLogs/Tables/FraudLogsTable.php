<?php

namespace App\Filament\Resources\FraudLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FraudLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Attempted At')
                    ->sortable(),
                TextColumn::make('product.title')
                    ->label('Target Product')
                    ->searchable(),
                TextColumn::make('affiliate.referral_code')
                    ->label('Ref Code')
                    ->placeholder('None'),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('reason')
                    ->badge()
                    ->color('danger')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('reason')
                    ->options([
                        'Duplicate phone number' => 'Duplicate Phone',
                        'Invalid referral code' => 'Invalid Ref Code',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
