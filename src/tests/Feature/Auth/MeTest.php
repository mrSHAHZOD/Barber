<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;
   

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = $this->createUser();

        $response = $this->getJson('/api/auth/me', $this->bearerHeaders($user));

        $response
            ->assertOk()
            ->assertJsonPath('data.name', $user->name);
    }

    public function test_unauthenticated_user_cannot_view_profile(): void
    {
        $this->getJson('/api/auth/me')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }
}
