<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $authService;

    /**
     * AuthService class constructor.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $userWithToken = $this->authService->registerUser($request);

        if ($userWithToken) {
            return $this->responseSuccess([
                'user' => new UserResource($userWithToken['user']),
                'token' => $userWithToken['token'],
                'message' => 'User registered successfully.',
            ]);
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while registering a user.',
        ]);
    }

    /**
     * Login a user.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $userWithToken = $this->authService->loginUser($request);

        if ($userWithToken) {
            return $this->responseSuccess([
                'user' => new UserResource($userWithToken['user']),
                'token' => $userWithToken['token'],
                'message' => 'User logged in successfully.',
            ]);
        }

        return $this->responseUnauthorizedEntityError([
            'message' => 'Bad credentials. Please try again.',
        ]);
    }

    /**
     * Logout a user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        if ($this->authService->logoutUser()) {
            return $this->responseSuccess([
                'message' => 'User logged out successfully.',
            ]);
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while logging out the user.',
        ]);
    }
}
