<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = Merchant::first();

        if (!$merchant) return;

        Product::firstOrCreate(
            ['title' => 'Algerian Smartphone X1'],
            [
                'merchant_id' => $merchant->id,
                'description' => 'High performance smartphone assembled in Algeria.',
                'commission_type' => 'fixed',
                'commission_value' => 2000.00,
                'is_active' => true,
            ]
        );

        Product::firstOrCreate(
            ['title' => 'Traditional Couscous Maker'],
            [
                'merchant_id' => $merchant->id,
                'description' => 'Automatic couscous maker for authentic taste.',
                'commission_type' => 'percent',
                'commission_value' => 10.0,
                'is_active' => true,
            ]
        );
    }
}
