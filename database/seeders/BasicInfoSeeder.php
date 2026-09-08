<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\ExtraService;
use App\Models\Location;
use App\Models\Pool;
use App\Models\Price;
use App\Models\Tariff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarModel::create([
            'name' => 'Chevrolet Cobalt',
            'description' => 'Cobalt',
            'seats' => 4,
        ]);

        CarModel::create([
            'name' => 'Chevrolet Gentra',
            'description' => 'Gentra',
            'seats' => 4,
        ]);

        CarModel::create([
            'name' => 'Chevrolet Nexia',
            'description' => 'Nexia',
            'seats' => 4,
        ]);

        Tariff::create([
            'name' => 'Standart',
            'number_of_seats' => 4
        ]);

        Tariff::create([
            'name' => 'Comfort',
            'number_of_seats' => 4
        ]);

        Tariff::create([
            'name' => 'Bussiness',
            'number_of_seats' => 4
        ]);

        Location::create([
            'name' => 'Toshkent',
            'type' => 1
        ]);

        Location::create([
            'name' => 'Fargona',
            'type' => 1
        ]);

        Location::create([
            'name' => 'Yunusobod',
            'type' => 2,
            'parent_id' => 1
        ]);

        Location::create([
            'name' => 'Margilon',
            'type' => 2,
            'parent_id' => 2
        ]);

        ExtraService::create([
            'name' => 'Tom bagaj',
            'price' => 150000
        ]);

        ExtraService::create([
            'name' => 'Orqa bagaj',
            'price' => 100000
        ]);

        Pool::create([
            'name' => "Reklama haydovchilar",
            'priority_level' => 1
        ]);

        Pool::create([
            'name' => "Reklamasiz haydovchilar",
            'priority_level' => 2
        ]);

        Pool::create([
            'name' => "Boshqa firma reklama haydovchilar",
            'priority_level' => 3
        ]);

        Price::create([
            'from_location_id' => 1,
            'to_location_id' => 2,
            'tariff_id' => 1,
            'base_price' => 140000,
            'front_seat_price' => 180000,
            'whole_car_price' => 580000,
            'peak_time_price' => 10000
        ]);
    }
}
