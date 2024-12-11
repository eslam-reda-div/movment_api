<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'notes' => fake()->text(40),
            'avatar_url' => null,
            'password' => bcrypt('password'),
            'company_id' => null,
            'home_address' => fake()->address(),
            'uuid' => fake()->uuid(),
        ];
    }
}
