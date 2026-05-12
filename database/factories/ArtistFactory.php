<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name() . ' Band',
            'formed_year' => fake()->numberBetween(1960, 2024),
        ];
    }
}
