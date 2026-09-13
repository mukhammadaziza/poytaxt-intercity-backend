<?php

namespace App\Actions\API\V1\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class CreateCarAction
{
     /**
     * @param array $data
     */
    public function execute(array $data)
    {
        return DB::transaction(function () use ($data) {

            $car = Car::create([
                'driver_id' => $data['driver_id'],
                'car_model_id' => $data['car_model_id'],
                'plate_number' => $data['plate_number'],
                'technical_pass_number' => $data['technical_pass_number'],
                'production_year' => $data['production_year']
            ]);

            return $car;
        });
    }
}
