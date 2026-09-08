<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Enums\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $faker = Faker::create();

        // Loop to generate 500 users
        for ($i = 0; $i < 500; $i++) {
            DB::table('users')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName(),
                'date_of_birth' => $faker->date('Y-m-d', '-18 years'),
                'gender' => $faker->randomElement([Gender::Male->value, Gender::Female->value]),
                'address' => $faker->address(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'balance' => $faker->randomFloat(2, 0, 5000),
                'status' => $faker->randomElement([UserStatus::Active->value, UserStatus::Archived->value]),
                'email_verified_at' => now(),
                'password' => 12345678,
                'remember_token' => Str::random(10),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-6 months', 'now'),
            ]);
        }
    }
}
