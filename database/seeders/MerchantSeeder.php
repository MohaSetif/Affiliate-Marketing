<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'merchant@example.com'],
            [
                'name' => 'Sample Merchant',
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole('merchant');

        Merchant::firstOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => 'Algeria Tech Store',
                'phone' => '0550123456',
                'whatsapp' => '0550123456',
                'approved_at' => now(),
            ]
        );
    }
}
