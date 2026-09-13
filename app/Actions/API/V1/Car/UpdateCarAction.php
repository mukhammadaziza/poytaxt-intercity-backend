<?php

namespace App\Actions\API\V1\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class UpdateCarAction
{
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
