<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'location_id' => 1,
                'company_id' => 1,
                'branch_id' => 1,
                'location_code' => 'LOC-STORE-001',
                'location_name' => 'Main Store',
                'location_type' => 'store',
                'parent_location_id' => null,
                'address' => '123 Gold Street, Mumbai',
                'contact_person' => 'Store Manager',
                'phone' => '1111111111',
                'capacity' => 1000,
                'temperature_controlled' => 1,
                'humidity_controlled' => 1,
                'security_level' => 'high',
                'status' => 'Active',
                'notes' => 'Primary retail location',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'location_id' => 2,
                'company_id' => 1,
                'branch_id' => 1,
                'location_code' => 'LOC-VAULT-001',
                'location_name' => 'Main Vault',
                'location_type' => 'vault',
                'parent_location_id' => 1,
                'address' => '123 Gold Street, Mumbai',
                'contact_person' => 'Security Officer',
                'phone' => '2222222222',
                'capacity' => 500,
                'temperature_controlled' => 1,
                'humidity_controlled' => 1,
                'security_level' => 'maximum',
                'status' => 'Active',
                'notes' => 'High-security vault',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'location_id' => 3,
                'company_id' => 2,
                'branch_id' => 1,
                'location_code' => 'LOC-WH-001',
                'location_name' => 'Central Warehouse',
                'location_type' => 'warehouse',
                'parent_location_id' => null,
                'address' => '456 Gem Avenue, Jaipur',
                'contact_person' => 'Warehouse Manager',
                'phone' => '3333333333',
                'capacity' => 2000,
                'temperature_controlled' => 0,
                'humidity_controlled' => 0,
                'security_level' => 'medium',
                'status' => 'Active',
                'notes' => 'Bulk storage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
