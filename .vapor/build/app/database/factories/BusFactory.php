<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bus>
 */
class BusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>L
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'number' => fake()->bothify('BUS-####'),
            'image_url' => null,
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'notes' => fake()->text(40),
            'seats_count' => fake()->numberBetween(10, 50),
            'latitude' => fake()->latitude(31.0300, 31.0600),  // Mansoura city bounds
            'longitude' => fake()->longitude(31.3500, 31.3900), // Mansoura city bounds
        ];
    }
}
