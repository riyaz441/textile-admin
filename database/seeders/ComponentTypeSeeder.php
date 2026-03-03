<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('component_types')->insert([
            [
                'company_id' => 1,
                'type_name' => 'Setting',
                'description' => 'Main setting for gemstone or material',
                'category' => 'Mounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 1,
                'type_name' => 'Shank',
                'description' => 'Band or shank of the ring',
                'category' => 'Band',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 1,
                'type_name' => 'Head',
                'description' => 'Head or top part of the jewelry',
                'category' => 'Top',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
