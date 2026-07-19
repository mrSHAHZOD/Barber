<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Business;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'branch_id' => Branch::factory(),
            'employee_position_id' => EmployeePosition::factory(),
            'user_id' => null,

            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->numerify('+998#########'),

            'birth_date' => fake()->date(),

            'gender' => fake()->randomElement(['male','female']),

            'experience_years' => fake()->numberBetween(0,20),

            'about' => fake()->paragraph(),

            'photo' => null,

            'rating' => fake()->randomFloat(1,4,5),

            'is_active' => true,
        ];
    }
}
