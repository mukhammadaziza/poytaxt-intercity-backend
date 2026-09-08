<?php

namespace App\Services\API\V1;

use App\Actions\API\V1\CreateDriverRouteAction;

class DriverRouteService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private CreateDriverRouteAction $createDriverRouteAction
    )
    {
        //
    }

    public function createRoute(array $data)
    {
        return $this->createDriverRouteAction->execute($data);
    }
}
