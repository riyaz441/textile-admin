<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->insert([
            [
                'supplier_id' => 1,
                'supplier_code' => 'SUP001',
                'company_id' => 1,
                'contact_person' => 'Rajesh Kumar',
                'email' => 'rajesh@goldpost.com',
                'phone' => '1234567890',
                'mobile' => '9876543210',
                'address' => '123 Gold Street, Mumbai',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'tax_id' => '27AAACG1234A1Z5',
                'payment_terms' => '30 Days',
                'bank_details' => 'ICICI Bank, A/C 123456789',
                'rating' => 4.5,
                'notes' => 'Preferred supplier',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'supplier_id' => 2,
                'supplier_code' => 'SUP002',
                'company_id' => 2,
                'contact_person' => 'Anita Sharma',
                'email' => 'anita@gemstonetraders.com',
                'phone' => '9876543210',
                'mobile' => '1234567890',
                'address' => '456 Gem Avenue, Jaipur',
                'city' => 'Jaipur',
                'state' => 'Rajasthan',
                'country' => 'India',
                'tax_id' => '08AAACG5678B1Z6',
                'payment_terms' => '15 Days',
                'bank_details' => 'SBI Bank, A/C 987654321',
                'rating' => 4.0,
                'notes' => 'Reliable supplier',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
