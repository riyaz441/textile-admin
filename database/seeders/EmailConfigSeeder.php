<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EmailConfigSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('email_configs')->insert([
            'protocol' => 'smtp',
            'mailtype' => 'html',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '587',
            'sender_email' => 'no-reply@goldpost.com',
            'password' => Crypt::encryptString('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
