<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Lead;
use App\Models\AffiliateRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MerchantStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        if (!$user || !$user->isMerchant()) {
            return [];
        }

        $merchantId = $user->merchant->id;

        $activeProducts = Product::where('merchant_id', $merchantId)->where('is_active', true)->count();
        $pendingLeads = Lead::whereHas('product', fn ($q) => $q->where('merchant_id', $merchantId))
            ->where('status', 'pending')
            ->count();
        $approvedLeadsThisMonth = Lead::whereHas('product', fn ($q) => $q->where('merchant_id', $merchantId))
            ->where('status', 'approved')
            ->where('approved_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        $approvedAffiliates = AffiliateRequest::where('merchant_id', $merchantId)
            ->where('status', 'approved')
            ->count();

        return [
            Stat::make('Active Products', $activeProducts)
                ->icon('heroicon-o-shopping-bag'),
            Stat::make('Pending Leads', $pendingLeads)
                ->description('Action required')
                ->icon('heroicon-o-exclamation-circle')
                ->color('warning'),
            Stat::make('Approved Leads (Month)', $approvedLeadsThisMonth)
                ->icon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make('Approved Affiliates', $approvedAffiliates)
                ->description('Partners promoting your products')
                ->icon('heroicon-o-users'),
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()?->isMerchant() ?? false;
    }
}
