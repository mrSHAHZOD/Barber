<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_register_successfully(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Shahzod',
            'phone' => '+998901112233',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful.',
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

        $this->assertDatabaseHas('users', [
            'phone' => '+998901112233',
            'name'  => 'Shahzod',
        ]);
    }

    /** @test */
    public function test_phone_must_be_unique(): void
    {
        User::factory()->create([
            'phone' => '+998901112233',
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Ali',
            'phone' => '+998901112233',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('phone');
    }

    /** @test */
    public function test_password_confirmation_must_match(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Ali',
            'phone' => '+998909999999',
            'password' => 'password123',
            'password_confirmation' => 'wrong-password',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('password');
    }

    /** @test */
    public function test_required_fields_are_validated(): void
    {
        $response = $this->postJson('/api/auth/register', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
                'phone',
                'password',
            ]);
    }
}
