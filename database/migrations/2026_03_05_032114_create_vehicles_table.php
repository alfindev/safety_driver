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
Schema::create('vehicles', function (Blueprint $table) {
    $table->id();
    $table->string('plate_number')->unique();  // B 1234 XYZ
    $table->string('type');                    // Truk, Minibus, Pick Up
    $table->string('brand')->nullable();
    $table->year('year')->nullable();
    $table->enum('status', ['active','maintenance','inactive'])->default('active');
    $table->string('stnk_number')->nullable();
    $table->date('stnk_expires_at')->nullable();
    $table->string('insurance_number')->nullable();
    $table->date('insurance_expires_at')->nullable();
    $table->timestamps();
});

// Pivot: driver <-> vehicle
Schema::create('driver_vehicle', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
