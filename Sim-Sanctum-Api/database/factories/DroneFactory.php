<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drone>
 */
class DroneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'drone_name' => $this->faker->word . ' Drone',
            'serial_number' => strtoupper($this->faker->bothify('SN-####-????')),
            'battrey_capacity_mah' => $this->faker->numberBetween(2000, 10000),
            'max_flight_time_minutes' => $this->faker->numberBetween(10, 60),
            'camera_specs' => json_encode([
                'type' => $this->faker->randomElement(['4K', '1080p', 'Thermal', 'Zoom']),
                'zoom' => $this->faker->boolean(50) ? $this->faker->numberBetween(2, 10) . 'x' : null,
                'features' => $this->faker->randomElements(['HDR', 'Night Vision', 'Stabilization', 'Wide Angle'], $this->faker->numberBetween(1, 3)),
            ]),
            'status' => $this->faker->numberBetween(0, 2),
            'last_maintenance_date' => $this->faker->date(),
        ];
    }
}
