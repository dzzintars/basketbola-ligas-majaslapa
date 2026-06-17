<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->firstNameMale() . ' ' . $this->faker->lastName(),
            'position' => $this->faker->randomElement(['PG', 'SG', 'SF', 'PF', 'C']),
            'jersey_number' => $this->faker->numberBetween(0, 99),
            'image_path' => null,
        ];
    }
}
