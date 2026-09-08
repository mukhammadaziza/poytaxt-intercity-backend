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
        Schema::create('driver_tariff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->constrained('users', 'id')
                ->cascadeOnDelete();

            $table->foreignId('tariff_id')
                ->constrained('tariffs', 'id')
                ->cascadeOnDelete();

            $table->primary(['driver_id', 'tariff_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_tariff');
    }
};
