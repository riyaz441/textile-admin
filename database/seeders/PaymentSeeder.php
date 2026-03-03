<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            'agent' => 'Razorpay',
            'merchant_id' => 'rzp_merchant_001',
            'api_key' => 'change-me',
            'status' => 'Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
