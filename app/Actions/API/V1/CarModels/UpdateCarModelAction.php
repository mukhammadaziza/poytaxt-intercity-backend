<?php

namespace App\Actions\API\V1\CarModels;

use App\Models\CarModel;
use Illuminate\Support\Facades\DB;

class UpdateCarModelAction
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
     * @param CarModel $carModel
     * @return CarModel
     */
    public function execute(array $data, CarModel $carModel): CarModel
    {
        return DB::transaction(function () use ($data, $carModel) {

            $carModel->update($data);

            return $carModel;
        });
    }
}
