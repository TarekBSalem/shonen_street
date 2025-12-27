<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): Response
    {
        $user = auth()->user();

        // Check if user is admin
        if ($user && $user->isAdmin()) {
            return $request->wantsJson() ? new JsonResponse('', 204) : redirect()->intended(config('fortify.home'));
        }

        // Non-admin users are not allowed to login
        auth()->logout();

        return $request->wantsJson()
            ? response()->json(['message' => 'Unauthorized. Admin access only.'], 403)
            : redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'This login is for administrators only.',
                ]);
    }
}
