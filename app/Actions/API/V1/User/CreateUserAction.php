<?php

namespace App\Actions\API\V1\User;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class CreateUserAction
{
    /**
     * @param array $data
     * @return User
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::query()
                ->with('roles')
                ->where('phone', $data['phone'])
                ->first();
            
            if ($user) {
                $roles = $user->roles->pluck('name')->implode(', ');

                throw ValidationException::withMessages([
                    'phone' => 'This user already exists. '
                        . 'You cannot create a user with this phone number. '
                        . 'Current roles: ' . $roles . '. '
                        . 'Check the profile with phone ' . $data['phone'],
                ]);

            } else {
                $user = User::create([
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'status' => UserStatus::Active->value,
                    'gender' => $data['gender'],
                    'phone' => $data['phone'],
                    'date_of_birth' => $data['date_of_birth'],
                    'password' => $data['password'],
                ]);

                $user->assignRole($data['role_ids']);

            }

            return $user;
        });
    }
}
