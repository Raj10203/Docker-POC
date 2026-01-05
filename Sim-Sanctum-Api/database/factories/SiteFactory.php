<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Solar Site',
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'is_active' => $this->faker->boolean(90),
            'size_in_mw' => $this->faker->numberBetween(1, 1000),
            'size_in_acre' => $this->faker->numberBetween(1, 500),
            'url' => $this->faker->unique()->url,
        ];
    }
}
