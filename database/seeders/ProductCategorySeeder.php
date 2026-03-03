<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['company_id' => 1, 'category_code' => 'JEW', 'category_name' => 'Jewelry', 'description' => 'Jewelry products', 'parent_category_id' => 0, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => 1, 'category_code' => 'GEM', 'category_name' => 'Gemstones', 'description' => 'Gemstone products', 'parent_category_id' => 0, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => 2, 'category_code' => 'MET', 'category_name' => 'Metals', 'description' => 'Metal products', 'parent_category_id' => 0, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['company_id' => 2, 'category_code' => 'ACC', 'category_name' => 'Accessories', 'description' => 'Accessory products', 'parent_category_id' => 0, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
