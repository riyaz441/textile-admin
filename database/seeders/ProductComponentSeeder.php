<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductComponentSeeder extends Seeder
{
    public function run(): void
    {
        // Example: Add a sample product component if product_id and component_type_id exist
        DB::table('product_components')->insert([
            [
                'product_id' => 1,
                'component_type_id' => 1,
                'component_name' => 'Main Setting',
                'material_id' => 1,
                'material_weight' => 2.5,
                'material_purity' => '18K',
                'gemstone_id' => 1,
                'gemstone_quantity' => 1,
                'gemstone_weight' => 0.5,
                'gemstone_carat_weight' => 0.5,
                'gemstone_shape' => 'Round',
                'gemstone_color' => 'D',
                'gemstone_clarity' => 'VVS1',
                'gemstone_cut_grade' => 'Excellent',
                'gemstone_certificate' => 'GIA123456',
                'dimension_length' => 5.00,
                'dimension_width' => 5.00,
                'dimension_height' => 3.00,
                'diameter' => 5.00,
                'component_cost' => 100.00,
                'labor_cost' => 20.00,
                'setting_cost' => 10.00,
                'position_order' => 1,
                'position_description' => 'Center',
                'is_main_component' => true,
                'notes' => 'Sample component',
                'created_at' => now(),
            ],
        ]);
    }
}
