<?php

namespace App\Actions\API\V1\Cars;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class DeleteCarAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Car $car
     * @return void
     */
    public function execute(Car $car): void
    {
        DB::transaction(function () use ($car) {
            $car->delete();
        });
    }
}
