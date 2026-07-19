<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessFactory extends Factory
{
    protected $model = Business::class;

    public function definition(): array
    {
        $name = fake()->company();

        return [
            'business_type_id' => BusinessType::factory(),
            'owner_id' => User::factory(),

            'name' => $name,
            'slug' => Str::slug($name),

            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),

            'description' => fake()->paragraph(),

            'logo' => null,
            'cover' => null,

            'is_active' => true,
            'has_multiple_branches' => false,
        ];
    }
}
