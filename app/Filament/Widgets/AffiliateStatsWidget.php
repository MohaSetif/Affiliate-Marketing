<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Commission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AffiliateStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        if (!$user || !$user->isAffiliate()) {
            return [];
        }

        $affiliateId = $user->affiliate->id;

        $totalLeads = Lead::where('affiliate_id', $affiliateId)->count();
        $approvedLeads = Lead::where('affiliate_id', $affiliateId)->where('status', 'approved')->count();
        $pendingCommission = Commission::where('affiliate_id', $affiliateId)->where('status', 'pending')->sum('amount');
        $paidCommission = Commission::where('affiliate_id', $affiliateId)->where('status', 'paid')->sum('amount');

        return [
            Stat::make('Total Leads', $totalLeads)
                ->description('All time leads generated')
                ->icon('heroicon-o-user-group'),
            Stat::make('Approved Leads', $approvedLeads)
                ->description('Leads converted to sales')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make('Pending Commission', 'DZD ' . number_format($pendingCommission, 2))
                ->description('Available for future withdrawal')
                ->icon('heroicon-o-clock'),
            Stat::make('Paid Commission', 'DZD ' . number_format($paidCommission, 2))
                ->description('Total payouts received')
                ->icon('heroicon-o-banknotes')
                ->color('primary'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()?->isAffiliate() ?? false;
    }
}
