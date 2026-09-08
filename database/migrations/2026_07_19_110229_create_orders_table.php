<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /*
    details = 
        {
        "seats": {
            "front": {
            "gender": "male",
            "price": 180000
            },
            "back_left": {
            "gender": "female",
            "price": 140000
            },
            "back_middle": {
            "gender": "male",
            "price": 140000
            },
            "back_right": {
            "gender": "male",
            "price": 140000
            },
            "any": {
            "gender": "male",
            "price": 140000
            }
        },
        "services": [1, 2],
        "preferences": ["cobalt", "gentra"]
        }


    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('users');
            $table->foreignId('tariff_id')
                    ->constrained('tariffs');
            $table->dateTime('departure_time')->nullable();
            $table->foreignId('from_location_id')
                ->constrained('locations');
            $table->foreignId('to_location_id')
                ->constrained('locations');
            $table->integer('order_type');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('status')->nullable();
            $table->integer('number_of_people')->nullable();
            $table->text('comment')->nullable();
            $table->jsonb('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
