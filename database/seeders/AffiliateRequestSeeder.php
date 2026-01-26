<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\AffiliateRequest;
use Illuminate\Database\Seeder;

class AffiliateRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $affiliate = Affiliate::first();
        $merchant = Merchant::first();

        if ($affiliate && $merchant) {
            AffiliateRequest::firstOrCreate(
                [
                    'affiliate_id' => $affiliate->id,
                    'merchant_id' => $merchant->id,
                ],
                [
                    'status' => 'approved',
                    'reviewed_at' => now(),
                ]
            );
        }
    }
}
