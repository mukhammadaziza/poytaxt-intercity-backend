<?php

namespace App\Actions\API\V1\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdateUserAction
{
    /**
     * @param array $data
     * @return User
     */
    public function execute(array $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {

            $existingUser = User::query()
                ->with('roles')
                ->where('phone', $data['phone'])
                ->where('id', '!=', $user->id)
                ->first();
            
            if ($existingUser) {
                $roles = $existingUser->roles->pluck('name')->implode(', ');

                throw ValidationException::withMessages([
                    'phone' => 'This user already exists. '
                        . 'You cannot create a user with this phone number. '
                        . 'Current roles: ' . $roles . '. '
                        . 'Check the profile with phone ' . $data['phone'],
                ]);

            } else {
                $user->update([
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'gender' => $data['gender'],
                    'phone' => $data['phone'],
                    'date_of_birth' => $data['date_of_birth']
                ]);

                if(!empty($data['password'])){
                    $user->update([
                        'password' => $data['password']
                    ]);
                }

                $user->syncRoles($data['role_ids']);
            }

            return $user;
        });
    }
}
