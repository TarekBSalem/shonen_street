<?php

namespace App\Actions\User;

use App\Models\User;

class DeleteUserAction
{
    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool
     */
    public function execute(User $user): bool
    {
        // Prevent deleting admin users
        if ($user->isAdmin()) {
            throw new \Exception('Cannot delete admin users.');
        }

        return $user->delete();
    }
}

