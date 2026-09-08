<?php

namespace App\Actions\API\V1;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateOrderAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * 
     */
    public function execute(array $data)
    {
        return DB::transaction(function () use ($data) {

            $orderType = match ($data['order_type']) {
                'person' => OrderType::Person->value,
                'parcel' => OrderType::Parcel->value,
            };

            $orderStatus = OrderStatus::Starter->value;

            $order = Order::create([
                'order_type' => $orderType,
                'tariff_id' => $data['tariff_id'],
                'departure_time' => $data['departure_time'],
                'from_location_id' => $data['from_location_id'],
                'to_location_id' => $data['to_location_id'],
                'phone_1' => $data['phone_1'],
                'phone_2' => $data['phone_2'],
                'status' => $orderStatus,
                'number_of_people' => $data['number_of_people'] ?? null,
                'comment' => $data['comment'] ?? null,
                'total_price' => $data['total_price'],
                'details' => [
                    'seats' => $data['seats'],
                    'whole_car' => $data['whole_car'],
                    'extra_services' => $data['extra_services']
                ],
            ]);

            return $order;
        });
    }   
}
