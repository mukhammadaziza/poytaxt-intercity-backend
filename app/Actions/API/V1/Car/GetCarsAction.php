<?php

namespace App\Actions\API\V1\Car;

use App\Models\Car;

class GetCarsAction
{
    /**
     * Create a new class instance.
     */
    public function execute()
    {
        return Car::all();
    }
}
