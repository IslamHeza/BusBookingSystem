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
        Schema::create('station_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0); //order of the station in the trip (1, 2, 3, ...)
            $table->float('distance_from_start_station')->default(0); //distance from the start station in the trip (in km)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('station_trip');
    }
};
