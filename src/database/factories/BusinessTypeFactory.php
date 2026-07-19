<?php

namespace Database\Factories;

use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BusinessTypeFactory extends Factory
{
    protected $model = BusinessType::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Barbershop',
            'Beauty Salon',
            'Spa',
            'Nail Studio',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => null,
            'is_active' => true,
        ];
    }
}
