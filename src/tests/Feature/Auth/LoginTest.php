<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_login_successfully(): void
    {
        $this->createUser([
            'phone' => '+998901112233',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone' => '+998901112233',
            'password' => 'password123',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'phone',
                        'email',
                    ],
                    'token',
                    'token_type',
                ],
            ]);
    }

    public function test_cannot_login_with_wrong_password(): void
    {
        $this->createUser([
            'phone' => '+998901112233',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'phone' => '+998901112233',
            'password' => 'wrongpassword',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['phone']);
    }

    public function test_login_validation_errors(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['phone', 'password']);
    }
}
