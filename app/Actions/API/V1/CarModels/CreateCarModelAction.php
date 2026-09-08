<?php

namespace App\Actions\API\V1\CarModels;

use App\Models\CarModel;
use Illuminate\Support\Facades\DB;

class CreateCarModelAction
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
     * @return CarModel
     */
    public function execute(array $data): CarModel
    {
        return DB::transaction(function () use ($data) {

            $carModel = CarModel::create([
                'name' => $data['name'],
                'seats' => $data['seats'],
                'description' => $data['description']
            ]);

            return $carModel;
        });
    }
}
