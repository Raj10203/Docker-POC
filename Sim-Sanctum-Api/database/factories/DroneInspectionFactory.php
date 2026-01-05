<?php

namespace Database\Factories;

use App\Models\Drone;
use App\Models\Inspection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DroneInspection>
 */
class DroneInspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'drone_id' => Drone::inRandomOrder()->first()->id,
            'inspection_id' => Inspection::inRandomOrder()->first()->id,
        ];
    }
}
