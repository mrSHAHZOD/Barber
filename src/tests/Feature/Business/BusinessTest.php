<?php

namespace Tests\Feature\Business;

use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected BusinessType $type;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->type = BusinessType::factory()->create();
    }

    public function test_owner_can_create_business(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/businesses', [
            'business_type_id' => $this->type->id,
            'name' => 'Beauty House',
            'phone' => '+998901112233',
            'email' => 'beauty@test.com',
            'description' => 'Best salon',
            'has_multiple_branches' => true,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('businesses', [
            'name' => 'Beauty House',
            'owner_id' => $this->user->id,
        ]);
    }

    public function test_validation_works(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/businesses', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'business_type_id',
                'name',
            ]);
    }

    public function test_guest_cannot_create_business(): void
    {
        $response = $this->postJson('/api/businesses', [
            'business_type_id' => $this->type->id,
            'name' => 'Beauty House',
        ]);

        $response->assertStatus(401);
    }

    public function test_owner_can_view_business(): void
    {
        Sanctum::actingAs($this->user);

        $business = Business::factory()->create([
            'owner_id' => $this->user->id,
            'business_type_id' => $this->type->id,
        ]);

        $this->getJson("/api/businesses/{$business->id}")
            ->assertOk();
    }

    public function test_owner_can_update_business(): void
    {
        Sanctum::actingAs($this->user);

        $business = Business::factory()->create([
            'owner_id' => $this->user->id,
            'business_type_id' => $this->type->id,
        ]);

        $this->putJson("/api/businesses/{$business->id}", [
            'business_type_id' => $this->type->id,
            'name' => 'Updated Business',
        ])
            ->assertOk();

        $this->assertDatabaseHas('businesses', [
            'id' => $business->id,
            'name' => 'Updated Business',
        ]);
    }

    public function test_owner_can_delete_business(): void
    {
        Sanctum::actingAs($this->user);

        $business = Business::factory()->create([
            'owner_id' => $this->user->id,
            'business_type_id' => $this->type->id,
        ]);

        $this->deleteJson("/api/businesses/{$business->id}")
            ->assertOk();

        $this->assertSoftDeleted($business);
    }

    public function test_another_user_cannot_update_business(): void
    {
        $owner = User::factory()->create();

        $business = Business::factory()->create([
            'owner_id' => $owner->id,
            'business_type_id' => $this->type->id,
        ]);

        Sanctum::actingAs($this->user);

        $this->putJson("/api/businesses/{$business->id}", [
            'business_type_id' => $this->type->id,
            'name' => 'Hack',
        ])
            ->assertForbidden();
    }

    public function test_another_user_cannot_delete_business(): void
    {
        $owner = User::factory()->create();

        $business = Business::factory()->create([
            'owner_id' => $owner->id,
            'business_type_id' => $this->type->id,
        ]);

        Sanctum::actingAs($this->user);

        $this->deleteJson("/api/businesses/{$business->id}")
            ->assertForbidden();
    }
}
