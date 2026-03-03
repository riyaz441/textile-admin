<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('websettings')->updateOrInsert(
            ['id' => 1],
            [
                'site_name' => 'GoldPost',
                'site_url' => 'http://localhost',
                'contact_person' => 'Admin',
                'contact_email' => 'admin@goldpost.com',
                'contact_phone' => '9854685484',
                'address' => '123 Main Street, City',
                'sales_email' => 'goldpostsales@gmail.com',
                'logo' => 'logo.png',
                'fav_icon' => 'fav_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
