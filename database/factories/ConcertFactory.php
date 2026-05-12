<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConcertFactory extends Factory
{
    public function definition(): array
    {
        return [
            'artist_id' => Artist::factory(),
            'city' => fake()->city(),
            'date' => fake()->dateTimeBetween('+1 week', '+1 year'),
        ];
    }
}
