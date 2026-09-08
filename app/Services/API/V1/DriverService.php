<?php

namespace App\Services\API\V1;

use App\Actions\API\V1\Driver\CreateDriverAction;

class DriverService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public CreateDriverAction $createDriverAction
    )
    {
        //
    }

    /**
     * @param array $data
     */
    public function createDriver(array $data)
    {
        $driver = $this->createDriverAction->execute($data);

        return $driver;
    }
}
