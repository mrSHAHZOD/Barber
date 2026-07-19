<?php

namespace Tests\Feature\Branch;

use App\Models\Branch;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Business $business;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $type = BusinessType::factory()->create();

        $this->business = Business::factory()->create([
            'owner_id' => $this->user->id,
            'business_type_id' => $type->id,
        ]);
    }

    public function test_owner_can_create_branch()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/branches',[
            'business_id'=>$this->business->id,
            'name'=>'Yunusobod',
            'phone'=>'+998901112233',
            'email'=>'yunus@test.com',
            'address'=>'Toshkent',
            'latitude'=>41.311,
            'longitude'=>69.279,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('branches',[
            'name'=>'Yunusobod'
        ]);
    }

    public function test_validation_works()
    {
        Sanctum::actingAs($this->user);

        $this->postJson('/api/branches',[])
            ->assertStatus(422);
    }

    public function test_guest_cannot_create_branch()
    {
        $this->postJson('/api/branches',[
            'business_id'=>$this->business->id,
            'name'=>'Branch'
        ])->assertUnauthorized();
    }
}
