<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\EmployeePosition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeePositionFactory extends Factory
{
    protected $model = EmployeePosition::class;

    public function definition(): array
    {
        $name = fake()->jobTitle();

        return [
            'business_id' => Business::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
