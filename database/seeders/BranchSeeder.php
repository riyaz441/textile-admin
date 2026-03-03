<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    public function run()
    {
        DB::table('branches')->insert([
            [
                'branch_id' => 1,
                'company_id' => 1,
                'branch_code' => 'BR001',
                'branch_name' => 'GoldPost Mumbai',
                'email' => 'mumbai@goldpost.com',
                'phone' => '1234567890',
                'address' => '123 Gold Street',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'branch_id' => 2,
                'company_id' => 2,
                'branch_code' => 'BR002',
                'branch_name' => 'Gemstone Jaipur',
                'email' => 'jaipur@gemstonetraders.com',
                'phone' => '9876543210',
                'address' => '456 Gem Avenue',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'country' => 'India',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
