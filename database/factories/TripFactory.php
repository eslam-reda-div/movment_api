<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'notes' => fake()->text(40),
            'start_at_time' => $this->faker->time(),
            'start_at_day' => $this->faker->dateTimeBetween('now', '+1 month'),
            'status' => 'scheduled',
        ];
    }
}
