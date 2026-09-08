<?php

namespace App\Actions\API\V1\CarModels;

use App\Models\CarModel;
use Illuminate\Support\Facades\DB;

class DeleteCarModelAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param CarModel $carModel
     * @return void
     */
    public function execute(CarModel $carModel): void
    {
        DB::transaction(function () use ($carModel) {
            $carModel->delete();
        });
    }
}
