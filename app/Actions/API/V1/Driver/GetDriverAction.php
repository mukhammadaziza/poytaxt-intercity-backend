<?php

namespace App\Actions\API\V1\Driver;

use App\Models\User;

class GetDriverAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $driver
     */
    public function execute(User $driver): User
    {
        return $driver->load([
            'car.carModel',
            'tariffs',
            'profile.pool'
        ]);
    }  
}
