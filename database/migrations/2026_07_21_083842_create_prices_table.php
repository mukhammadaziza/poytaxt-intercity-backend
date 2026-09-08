<?php

use App\Models\Price;
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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_location_id')
                ->constrained('locations');
            $table->foreignId('to_location_id')
                ->constrained('locations');
            $table->foreignId('tariff_id')
                ->constrained('tariffs');
            $table->integer('base_price');
            $table->integer('front_seat_price')->nullable();
            $table->integer('whole_car_price')->nullable();
            $table->integer('peak_time_price')->nullable();
            $table->dateTime('peak_time_start_date')->nullable();
            $table->dateTime('peak_time_end_date')->nullable();
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
        Schema::dropIfExists('prices');
    }
};
