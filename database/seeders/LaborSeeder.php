<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaborSeeder extends Seeder
{
    public function run()
    {
        DB::table('labors')->insert([
            [
                'company_id' => 1,
                'labor_code' => 'LAB001',
                'labor_name' => 'Goldsmith',
                'description' => 'Expert in gold jewelry making',
                'base_cost' => 5000.00,
                'cost_per_hour' => 250.00,
                'estimated_hours' => 40.00,
                'skill_level' => 'master',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'labor_code' => 'LAB002',
                'labor_name' => 'Gem Cutter',
                'description' => 'Specialist in gemstone cutting',
                'base_cost' => 3000.00,
                'cost_per_hour' => 180.00,
                'estimated_hours' => 30.00,
                'skill_level' => 'advanced',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
