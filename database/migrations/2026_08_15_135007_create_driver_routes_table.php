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
        Schema::create('driver_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->constrained('users');
            $table->foreignId('from_location_id')
                ->constrained('locations');
            $table->foreignId('to_location_id')
                ->constrained('locations');;
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->jsonb('occupied_seats')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_routes');
    }
};
