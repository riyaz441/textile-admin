<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->updateOrInsert(
            ['sku' => 'RING001'],
            [
                'product_name' => 'Gold Diamond Ring',
                'company_id' => 1,
                'cost_price' => 100.00,
                'selling_price' => 200.00,
                'category_id' => null,
                'material_id' => 1,
                'gemstone_id' => 1,
                'quantity_in_stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
