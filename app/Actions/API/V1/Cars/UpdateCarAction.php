<?php

namespace App\Actions\API\V1\Cars;

use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateCarAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param array $data
     * @param Car $car
     * @return Car
     */
    public function execute(array $data, Car $car): Car
    {
        return DB::transaction(function () use ($data, $car) {

            $car->update($data);

            return $car;
        });
    }
}
