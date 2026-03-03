<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->insert([
            [
                'company_id' => 1,
                'company_code' => 'COMP001',
                'company_name' => 'GoldPost Ltd.',
                'email' => 'info@goldpost.com',
                'phone' => '1234567890',
                'address' => '123 Gold Street',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'gst_number' => '27AAACG1234A1Z5',
                'website' => 'https://goldpost.com',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 2,
                'company_code' => 'COMP002',
                'company_name' => 'Gemstone Traders',
                'email' => 'contact@gemstonetraders.com',
                'phone' => '9876543210',
                'address' => '456 Gem Avenue',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'country' => 'India',
                'gst_number' => '08AAACG5678B1Z6',
                'website' => 'https://gemstonetraders.com',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
