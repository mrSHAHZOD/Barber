<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Authentication', description: 'Sanctum token authentication endpoints')]
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    #[OA\Post(
        path: '/api/auth/register',
        summary: 'Register a user',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name', 'phone', 'password', 'password_confirmation'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Ali Valiyev'),
                new OA\Property(property: 'phone', type: 'string', example: '+998901234567'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
                new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'password123'),
            ]
        )),
        responses: [
            new OA\Response(response: 201, description: 'Registered', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'success', type: 'boolean', example: true),
                new OA\Property(property: 'message', type: 'string', example: 'Registration successful.'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'user', ref: '#/components/schemas/User'),
                    new OA\Property(property: 'token', type: 'string'),
                    new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                ], type: 'object'),
            ])),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return $this->authenticatedResponse($user, 'Registration successful.', 201);
    }

    #[OA\Post(
        path: '/api/auth/login',
        summary: 'Login and receive a Sanctum token',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['phone', 'password'],
            properties: [
                new OA\Property(property: 'phone', type: 'string', example: '+998901234567'),
                new OA\Property(property: 'password', type: 'string', format: 'password', example: 'password123'),
            ]
        )),
        responses: [
            new OA\Response(response: 200, description: 'Authenticated'),
            new OA\Response(response: 401, description: 'Invalid credentials'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->validated());

        if (! $user) {
            return $this->error('The provided credentials are incorrect.', status: 401);
        }

        return $this->authenticatedResponse($user, 'Login successful.');
    }

    #[OA\Get(
        path: '/api/auth/me',
        summary: 'Get the authenticated user',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(response: 200, description: 'Authenticated user'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return $this->success($this->userData($request->user()), 'Authenticated user retrieved.');
    }

    #[OA\Post(
        path: '/api/auth/logout',
        summary: 'Revoke the current Sanctum token',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        responses: [
            new OA\Response(response: 200, description: 'Logged out'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success(message: 'Logout successful.');
    }

    private function authenticatedResponse(User $user, string $message, int $status = 200): JsonResponse
    {
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->success([
            'user' => $this->userData($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], $message, $status);
    }

    /** @return array{id: int, name: string, phone: string|null, email: string|null} */
    private function userData(User $user): array
    {
        return $user->only(['id', 'name', 'phone', 'email']);
    }

    #[OA\Post(
        path: '/api/auth/change-password',
        summary: 'Change the authenticated user\'s password',
        security: [['bearerAuth' => []]],
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'current_password', type: 'string', format: 'password', example: 'oldpassword123'),
                        new OA\Property(property: 'password', type: 'string', format: 'password', example: 'newpassword123'),
                        new OA\Property(property: 'password_confirmation', type: 'string', format: 'password', example: 'newpassword123'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Password changed'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        $this->authService->changePassword($user, $request->validated());

        return $this->success(message: 'Parol muvaffaqiyatli o‘zgartirildi.');
    }
}
