<?php

namespace App\Actions\API\V1;

use App\Enums\DriverLogStatus;
use App\Models\DriverLog;
use App\Models\DriverRoute;
use Illuminate\Support\Facades\DB;

class CreateDriverRouteAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(array $data)
    {
        return DB::transaction(function () use ($data) {

            $driverRoute = DriverRoute::create([
                'driver_id' => auth()->user()->id,
                'from_location_id' => $data['from_location_id'],
                'to_location_id' => $data['to_location_id'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'occupied_seats' => $data['occupied_seats']
            ]);

            DriverLog::create([
                'driver_id' => auth()->user()->id,
                'status' => DriverLogStatus::CreatedRoute->value,
                'details' => [
                    'from_location_id' => $data['from_location_id'],
                    'to_location_id' => $data['to_location_id'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'occupied_seats' => $data['occupied_seats']
                ]
            ]);

            return $driverRoute;
        });
    }
}
