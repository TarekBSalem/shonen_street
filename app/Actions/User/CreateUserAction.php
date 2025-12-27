<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function execute(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false, // Always false for regular users
            'email_verified_at' => now(), // Auto-verify users created by admin
        ]);
    }
}
