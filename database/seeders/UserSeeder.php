<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 regular users for testing
        \App\Models\User::factory()
            ->count(20)
            ->create([
                'is_admin' => false,
            ]);
    }
}
