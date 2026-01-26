<?php

namespace App\Filament\Resources\Withdrawals\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('method')
                    ->options([
                        'cash' => 'Cash',
                        'ccp' => 'CCP',
                        'baridimob' => 'BaridiMob',
                        'bank' => 'Bank Transfer',
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->minValue(5000)
                    ->rules([
                        fn () => function (string $attribute, $value, $fail) {
                            $user = Auth::user();
                            if (!$user || !$user->isAffiliate()) {
                                return;
                            }
                            
                            $pendingAmount = Commission::where('affiliate_id', $user->affiliate->id)
                                ->where('status', 'pending')
                                ->sum('amount');
                            
                            if ($value > $pendingAmount) {
                                $fail("You only have DZD {$pendingAmount} available for withdrawal.");
                            }
                        },
                    ]),
                Textarea::make('account_info')
                    ->label('Payment Details (CCP Number, Bank Account, etc.)')
                    ->required(),
                TextInput::make('notes')
                    ->label('Notes')
                    ->nullable(),
                Hidden::make('affiliate_id')
                    ->default(Auth::user()?->affiliate?->id)
                    ->required(),
            ]);
    }
}
