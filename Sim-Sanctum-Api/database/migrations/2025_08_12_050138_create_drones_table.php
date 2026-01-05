<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->id();
            $table->string('drone_name');
            $table->string('serial_number')->unique();
            $table->string('battrey_capacity_mah')->nullable();
            $table->string('max_flight_time_minutes')->nullable();
            $table->json('camera_specs')->nullable();
            $table->integer('status')->default(0);
            $table->date('last_maintenance_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drones');
    }
};
