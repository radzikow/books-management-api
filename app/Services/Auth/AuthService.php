<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register a user.
     *
     * @param RegisterRequest $request
     *
     * @return Array
     */
    public function registerUser(RegisterRequest $request): array
    {
        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return [
            'user' => $user,
            'token' => $this->createAuthToken($user),
        ];
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     *
     * @return Array|null
     */
    public function loginUser(LoginRequest $request): ?array
    {
        $user = User::where('email', $request->get('email'))->first();

        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return null;
        }

        return [
            'user' => $user,
            'token' => $this->createAuthToken($user),
        ];
    }

    /**
     * Logout a user.
     *
     * @return bool
     */
    public function logoutUser(): bool
    {
        $this->removeUserAuthTokens();

        return true;
    }

    /**
     * Create a auth token for a user.
     *
     * @return string
     */
    protected function createAuthToken($user): string
    {
        return $user->createToken('app-token')->plainTextToken;
    }

    /**
     * Remove user auth tokens.
     *
     * @return void
     */
    protected function removeUserAuthTokens(): void
    {
        auth()->user()->tokens()->delete();
    }
}
