<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'company_id' => null,
                'branch_id' => null,
                'setting_key' => 'site.title',
                'setting_value' => 'Gold Post',
                'setting_type' => 'string',
                'category' => 'General',
                'description' => 'Application title displayed in the header and browser title.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => null,
                'branch_id' => null,
                'setting_key' => 'site.timezone',
                'setting_value' => 'Asia/Kolkata',
                'setting_type' => 'string',
                'category' => 'General',
                'description' => 'Default timezone used across the application.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => null,
                'branch_id' => null,
                'setting_key' => 'tax.enabled',
                'setting_value' => 'true',
                'setting_type' => 'boolean',
                'category' => 'Tax',
                'description' => 'Enable or disable tax calculations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => null,
                'branch_id' => null,
                'setting_key' => 'tax.rate',
                'setting_value' => '3.0',
                'setting_type' => 'number',
                'category' => 'Tax',
                'description' => 'Default tax percentage rate.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => null,
                'branch_id' => null,
                'setting_key' => 'invoice.footer',
                'setting_value' => 'Thank you for your business.',
                'setting_type' => 'string',
                'category' => 'Invoice',
                'description' => 'Footer note printed on invoices.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
