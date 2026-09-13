<?php

namespace App\Actions\API\V1\Car;

use App\Models\Car;
use Illuminate\Support\Facades\DB;

class DeleteCarAction
{
  
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
