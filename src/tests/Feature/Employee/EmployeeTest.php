<?php

namespace Tests\Feature\Employee;

use App\Models\Branch;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Business $business;
    private Branch $branch;
    private EmployeePosition $position;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $type = BusinessType::factory()->create();

        $this->business = Business::factory()->create([
            'owner_id' => $this->user->id,
            'business_type_id' => $type->id,
        ]);

        $this->branch = Branch::factory()->create([
            'business_id' => $this->business->id,
        ]);

        $this->position = EmployeePosition::factory()->create([
            'business_id' => $this->business->id,
        ]);
    }

    public function test_owner_can_create_employee(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/employees', [
            'business_id' => $this->business->id,
            'branch_id' => $this->branch->id,
            'employee_position_id' => $this->position->id,

            'first_name' => 'Ali',
            'last_name' => 'Valiyev',

            'phone' => '+998901112233',
            'email' => 'ali@test.com',

            'gender' => 'male',
            'experience_years' => 5,
            'is_active' => true,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('employees', [
            'phone' => '+998901112233',
        ]);
    }

    public function test_validation_works(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/employees', []);

        $response->assertStatus(422);
    }

    public function test_owner_can_update_employee(): void
    {
        Sanctum::actingAs($this->user);

        $employee = Employee::factory()->create([
            'business_id' => $this->business->id,
            'branch_id' => $this->branch->id,
            'employee_position_id' => $this->position->id,
        ]);

        $response = $this->putJson("/api/employees/{$employee->id}", [
            'first_name' => 'Updated',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => 'Updated',
        ]);
    }

    public function test_owner_can_delete_employee(): void
    {
        Sanctum::actingAs($this->user);

        $employee = Employee::factory()->create([
            'business_id' => $this->business->id,
            'branch_id' => $this->branch->id,
            'employee_position_id' => $this->position->id,
        ]);

        $response = $this->deleteJson("/api/employees/{$employee->id}");

        $response->assertOk();

        $this->assertSoftDeleted('employees', [
            'id' => $employee->id,
        ]);
    }
}
