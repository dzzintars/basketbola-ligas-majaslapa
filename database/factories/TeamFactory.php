<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamNames = [
            'Hawks',
            'Celtics',
            'Nets',
            'Hornets',
            'Bulls',
            'Cavaliers',
            'Mavericks',
            'Nuggets',
            'Pistons',
            'Warriors',
            'Rockets',
            'Pacers',
            'Clippers',
            'Lakers',
            'Grizzlies',
        ];
        $city = $this->faker->city();

        return [
            'name' => $city . ' ' . $this->faker->randomElement($teamNames),
            'city' => $city,
            'logo_path' => 'logos/logo' . rand(1, 4) . '.png',
        ];
    }
}
