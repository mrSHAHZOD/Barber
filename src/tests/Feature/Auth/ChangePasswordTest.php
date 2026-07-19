<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_change_password(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ], $this->bearerHeaders($user));

        $response
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertTrue(Hash::check('newpassword', $user->refresh()->password));
    }

    public function test_unauthenticated_user_cannot_change_password(): void
    {
        $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_current_password_must_be_correct(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->postJson('/api/auth/change-password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ], $this->bearerHeaders($user))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['current_password']);
    }

    public function test_password_confirmation_must_match(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->postJson('/api/auth/change-password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'differentpassword',
        ], $this->bearerHeaders($user))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['password']);
    }
}
