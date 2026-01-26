<?php

namespace App\Filament\Widgets;

use App\Models\Merchant;
use App\Models\Affiliate;
use App\Models\Commission;
use App\Models\Withdrawal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AdminStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        if (!Auth::user()?->isAdmin()) {
            return [];
        }

        $approvedMerchants = Merchant::whereNotNull('approved_at')->count();
        $totalAffiliates = Affiliate::count();
        $totalCommissions = Commission::sum('amount');
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();
        $pendingWithdrawalsAmount = Withdrawal::where('status', 'pending')->sum('amount');

        return [
            Stat::make('Approved Merchants', $approvedMerchants)
                ->icon('heroicon-o-building-storefront'),
            Stat::make('Total Affiliates', $totalAffiliates)
                ->icon('heroicon-o-users'),
            Stat::make('Total Commissions Earned', 'DZD ' . number_format($totalCommissions, 2))
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
            Stat::make('Pending Withdrawals', $pendingWithdrawalsCount)
                ->description('Total: DZD ' . number_format($pendingWithdrawalsAmount, 2))
                ->icon('heroicon-o-banknotes')
                ->color('danger'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }
}
