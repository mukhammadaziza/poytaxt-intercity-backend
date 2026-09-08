<?php

namespace App\Actions\API\V1\Driver;

use App\Models\User;

class GetDriverOrdersAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(User $driver)
    {
        return 'ok';
    }
}
