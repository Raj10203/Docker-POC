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
        Schema::create('drone_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drone_id')
                ->constrained('drones')
                ->cascadeOnDelete();
            $table->foreignId('inspection_id')
                ->constrained('inspections')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drone_inspections');
    }
};
