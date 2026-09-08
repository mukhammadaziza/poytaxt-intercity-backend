<?php

namespace App\Actions\API\V1\User;

use App\Models\User;

class CheckIfUserExistAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(array $data): User|null
    {
        return User::query()
                ->with('roles')
                ->where('phone', $data['phone'])
                ->first();
    }
}
