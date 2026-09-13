<?php

namespace App\Actions\API\V1\User;

use App\Models\User;

class GetUserAction
{
    /**
     * Create a new class instance
     * @return User
     */
    public function execute(User $user): User
    {
        return $user->load([
            'roles'
        ]);
    } 
}
