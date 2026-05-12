<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Concert;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'concert_id' => Concert::factory(),
            'price' => fake()->randomFloat(2, 20, 200),
            'seat_number' => fake()->bothify('??-###'),
        ];
    }
}
