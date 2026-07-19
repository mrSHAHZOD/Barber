<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/auth/logout', [], $this->bearerHeaders($user));

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful.',
            ]);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/auth/logout');

        $response
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_authenticated_user_cannot_access_protected_routes_after_logout(): void
    {
        $user = $this->createUser();
        $headers = $this->bearerHeaders($user);

        $this->postJson('/api/auth/logout', [], $headers)->assertOk();
        $this->assertDatabaseCount('personal_access_tokens', 0);
        $this->app['auth']->forgetGuards();

        $response = $this->getJson('/api/auth/me', $headers);

        $response
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }

    public function test_authenticated_user_can_login_again_after_logout(): void
    {
        $user = $this->createUser([
            'password' => bcrypt('password123'),
        ]);
        $headers = $this->bearerHeaders($user);

        $this->postJson('/api/auth/logout', [], $headers)->assertOk();

        $response = $this->postJson('/api/auth/login', [
            'phone' => $user->phone,
            'password' => 'password123',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
            ]);
    }
}
