<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'material_name' => 'Yellow Gold',
                'description' => 'Traditional gold alloy used in jewelry',
                'carat_purity' => '18K',
                'density' => 15.6000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_name' => 'White Gold',
                'description' => 'Gold alloy with a bright white finish',
                'carat_purity' => '14K',
                'density' => 14.7000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_name' => 'Sterling Silver',
                'description' => 'Silver alloy with 92.5% purity',
                'carat_purity' => '925',
                'density' => 10.4900,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_name' => 'Platinum',
                'description' => 'Premium metal with high purity and durability',
                'carat_purity' => '950',
                'density' => 21.4500,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
