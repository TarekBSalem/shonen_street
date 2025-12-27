<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function execute(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        // Only update password if provided
        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user->fresh();
    }
}
