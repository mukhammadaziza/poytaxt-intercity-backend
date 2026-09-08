<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use App\Models\DriverProfile;
use App\Models\Pool;
use App\Models\Tariff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        Role::create([
            'name' => 'Driver',
            'guard_name' => 'web',
        ]);
        $users = User::inRandomOrder()->limit(200)->get();
        $tariffIds = Tariff::pluck('id')->all(); // e.g. [1, 2, 3]
        foreach ($users as $user) {
            $user->assignRole('Driver');

            DriverProfile::create([
                'driver_id' => $user->id,
                'pool_id' => rand(1, 3),
                'status' => rand(1, 4),
                'driver_balance' => rand(0, 9000000),
                'commission_type' => rand(1, 2),
                'commission_value' => rand(5, 20),
            ]);

            Car::create([
                'driver_id' => $user->id,
                'car_model_id' => rand(1, 3),
                'plate_number' => $faker->postcode(),
                'technical_pass_number' => $faker->postcode(),
                'production_year' => $faker->year(2026),
            ]);

            $user->tariffs()->attach(
                collect($tariffIds)->random(rand(1, count($tariffIds)))
            );
        }
    }
}