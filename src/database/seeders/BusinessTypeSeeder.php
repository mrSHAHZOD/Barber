<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessType::insert([
            [
                'name' => 'Barber Shop',
                'slug' => 'barber-shop'
            ],
            [
                'name' => 'Beauty Salon',
                'slug' => 'beauty-salon'
            ],
            [
                'name' => 'SPA'
            ,    'slug' => 'spa'
            ],
            [
                'name' => 'Massage Center',
                'slug' => 'massage-center'
            ],
            [
                'name' => 'Nail Studio',
                'slug' => 'nail-studio'
            ],
        ]);
            }
}
