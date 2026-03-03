<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryStockSeeder extends Seeder
{
    public function run(): void
    {
        $productId = DB::table('products')->where('sku', 'RING001')->value('product_id');
        $mainStoreLocationId = DB::table('locations')->where('location_code', 'LOC-STORE-001')->value('location_id');
        $mainVaultLocationId = DB::table('locations')->where('location_code', 'LOC-VAULT-001')->value('location_id');

        if (!$productId || !$mainStoreLocationId) {
            return;
        }

        DB::table('inventory_stocks')->updateOrInsert(
            [
                'product_id' => $productId,
                'location_id' => $mainStoreLocationId,
            ],
            [
                'quantity_on_hand' => 50,
                'quantity_allocated' => 12,
                'reorder_point' => 20,
                'reorder_quantity' => 40,
                'last_reorder_date' => now()->subDays(14)->toDateString(),
                'next_reorder_date' => now()->addDays(16)->toDateString(),
                'average_cost' => 125.50,
                'stock_turnover_rate' => 4.75,
                'days_in_stock' => 45,
                'last_movement_date' => now()->subDays(2)->toDateString(),
                'safety_stock_level' => 10,
                'minimum_stock_level' => 15,
                'maximum_stock_level' => 120,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        if ($mainVaultLocationId) {
            DB::table('inventory_stocks')->updateOrInsert(
                [
                    'product_id' => $productId,
                    'location_id' => $mainVaultLocationId,
                ],
                [
                    'quantity_on_hand' => 30,
                    'quantity_allocated' => 5,
                    'reorder_point' => 10,
                    'reorder_quantity' => 25,
                    'last_reorder_date' => now()->subDays(21)->toDateString(),
                    'next_reorder_date' => now()->addDays(9)->toDateString(),
                    'average_cost' => 124.00,
                    'stock_turnover_rate' => 3.10,
                    'days_in_stock' => 62,
                    'last_movement_date' => now()->subDays(4)->toDateString(),
                    'safety_stock_level' => 8,
                    'minimum_stock_level' => 12,
                    'maximum_stock_level' => 80,
                    'status'=> 'Active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
