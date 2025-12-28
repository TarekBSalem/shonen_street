<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a dummy admin user for receiving notifications
        $admin = User::firstOrCreate(
            ['email' => 'admin@shonenstreet.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );

        $this->command->info('✓ Admin user created successfully!');
        $this->command->info('  Email: admin@shonenstreet.test');
        $this->command->info('  Password: password');
        $this->command->info('  This admin will receive low stock and daily sales report notifications.');
    }
}
