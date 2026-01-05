<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => \App\Models\Site::inRandomOrder()->value('id') ?? \App\Models\Site::factory(),
            'inspection_date' => $this->faker->date(),
            'inspector_id' => \App\Models\User::inRandomOrder()->value('id') ?? \App\Models\User::factory(),
            'status' => $this->faker->numberBetween(0, 2),
        ];
    }
}
