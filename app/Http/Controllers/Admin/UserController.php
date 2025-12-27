<?php

namespace App\Http\Controllers\Admin;

use App\Actions\User\CreateUserAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of users (non-admin only).
     */
    public function index(): Response
    {
        $users = User::where('is_admin', false)->orderBy('created_at', 'desc')->paginate(15)->through(
            fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at?->format('Y-m-d H:i'),
                'created_at' => $user->created_at->format('Y-m-d H:i'),
            ],
        );

        return Inertia::render('admin/users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request, CreateUserAction $action)
    {
        try {
            $user = $action->execute($request->validated());

            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action)
    {
        // Prevent updating admin users
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot update admin users.']);
        }

        try {
            $action->execute($user, $request->validated());

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user, DeleteUserAction $action)
    {
        try {
            $action->execute($user);

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
