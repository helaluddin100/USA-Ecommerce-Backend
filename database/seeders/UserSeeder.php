<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'company_name' => 'System Admin',
            'country' => 'United States',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'contact_name' => 'Super Admin',
            'nda_agreement' => true,
            'nda_agreed_at' => now(),
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // Create Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'company_name' => 'Admin Company',
            'country' => 'United States',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip' => '90001',
            'contact_name' => 'Admin User',
            'nda_agreement' => true,
            'nda_agreed_at' => now(),
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'company_name' => 'Test Company',
            'country' => 'United States',
            'city' => 'Chicago',
            'state' => 'IL',
            'zip' => '60601',
            'contact_name' => 'Test User',
            'type_of_business' => 'retailer',
            'registration_path' => 'stylekorean',
            'interesting_business' => ['kpop', 'kbeauty'],
            'nda_agreement' => true,
            'nda_agreed_at' => now(),
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // Create Blocked User (for testing)
        User::create([
            'username' => 'blocked',
            'email' => 'blocked@example.com',
            'password' => Hash::make('password'),
            'role' => 'block_user',
            'company_name' => 'Blocked Company',
            'country' => 'United States',
            'city' => 'Miami',
            'state' => 'FL',
            'zip' => '33101',
            'contact_name' => 'Blocked User',
            'nda_agreement' => true,
            'nda_agreed_at' => now(),
            'is_active' => false,
            'approved_at' => null,
        ]);
    }
}

