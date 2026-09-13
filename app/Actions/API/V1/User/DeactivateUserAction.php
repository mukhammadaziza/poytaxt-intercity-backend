<?php

namespace App\Actions\API\V1\User;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeactivateUserAction
{
    /**
     * Deactivate user
     * 
     * @param User $user
     * @return User
     */
    public function execute(User $user): User
    {
        return DB::transaction(function () use ($user) {

            $user->update([
                'status' => UserStatus::Deactivated->value
            ]);

            return $user;
        });
    }
}
