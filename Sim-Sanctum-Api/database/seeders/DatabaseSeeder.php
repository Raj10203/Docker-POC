<?php

namespace Database\Seeders;

use App\Models\Drone;
use App\Models\DroneInspection;
use App\Models\Inspection;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'john@example.com'
        ]);
        User::factory()->count(10)->create();

        Site::factory()->count(12)->create();
        Drone::factory()->count(5)->create();

        Inspection::factory()->count(30)->create();
        DroneInspection::factory()->count(50)->create();

    }
}
