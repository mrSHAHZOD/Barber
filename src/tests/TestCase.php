<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    /** @return array<string, string> */
    protected function bearerHeaders(User $user): array
    {
        $token = $user->createToken('test-token')->plainTextToken;

        return ['Authorization' => "Bearer {$token}"];
    }
}
