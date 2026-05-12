<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'genre_id' => Genre::factory(),
            'title' => fake()->word() . ' ' . fake()->word(),
            'duration' => fake()->numberBetween(120, 360),
        ];
    }
}
