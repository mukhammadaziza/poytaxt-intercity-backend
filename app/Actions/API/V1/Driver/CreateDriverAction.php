<?php

namespace App\Actions\API\V1\Driver;

use App\Enums\DriverProfileStatus;
use App\Enums\UserStatus;
use App\Models\Car;
use App\Models\DriverProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class CreateDriverAction
{
    /**
     * @param array $data
     * @return User
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $user = User::query()
                ->where('phone', $data['phone'])
                ->first();
            $car = Car::query()
                ->where('plate_number', $data['plate_number'])
                ->first();
            
            if ($user && $user->hasRole('Driver')) {
                throw ValidationException::withMessages([
                    'phone' => 'This user is already existing driver. 
                            You cannot create driver with this phone number.
                            Check driver profile with phone ' . $data['phone']
                ]);
            } elseif($car){
                throw ValidationException::withMessages([
                    'plate_number' => 'This plate number is already registered. 
                        You cannot create driver with this plate number.
                        Check driver profile with phone ' . $data['plate_number']
                ]);
            } else {
                $driver = User::create([
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

                $driver->assignRole('Driver');
                $driver->tariffs()->sync($data['tariff_ids']);
                
                Car::create([
                    'driver_id' => $driver->id,
                    'car_model_id' => $data['car_model_id'],
                    'plate_number' => $data['plate_number'],
                    'production_year' => $data['production_year'],
                    'technical_pass_number' => $data['technical_pass_number'],
                ]);
                
                DriverProfile::create([
                    'driver_id' => $driver->id,
                    'pool_id' => $data['pool_id'],
                    'status' => DriverProfileStatus::Active->value,
                    'commission_type' => $data['commission_type'],
                    'commission_value' => $data['commission_value']
                ]);
            }

            return $driver;
        });
    }
}
