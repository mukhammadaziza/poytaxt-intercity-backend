<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'order_type' => $this->order_type,
            'tariff_id' => $this->tariff_id,
            'from_location_id' => $this->from_location_id,
            'to_location_id' => $this->to_location_id,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'status' => $this->status,
            'number_of_people' => $this->number_of_people,
            'comment' => $this->comment,
            'total_price' => $this->total_price,
            'details' => $this->details
        ];
    }
}
