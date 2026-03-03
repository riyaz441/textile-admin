<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CompanySeeder::class,
            BranchSeeder::class,
            LocationSeeder::class,
            SupplierSeeder::class,
            LaborSeeder::class,
            ProductCategorySeeder::class,
            MaterialSeeder::class,
            MeasurementSeeder::class,
            GemstoneSeeder::class,
            ProductSeeder::class,
            InventoryStockSeeder::class,
            ComponentTypeSeeder::class,
            ProductComponentSeeder::class,
            EmailConfigSeeder::class,
            PaymentSeeder::class,
            WebsettingSeeder::class,
            ApplicationSettingSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin@2026'),
        ]);
    }
}
