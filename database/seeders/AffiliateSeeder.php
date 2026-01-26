<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'affiliate@example.com'],
            [
                'name' => 'Top Affiliate',
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole('affiliate');

        Affiliate::firstOrCreate(
            ['user_id' => $user->id],
            [
                'referral_code' => 'AFF12X7K',
            ]
        );
    }
}
