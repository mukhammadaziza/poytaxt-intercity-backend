<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'from_location_id' => $this->from_location_id,
            'to_location_id' => $this->to_location_id,
            'from_location' => $this->fromLocation?->name,
            'to_location' => $this->toLocation?->name,
            'base_price' => $this->base_price,
            'front_seat_price' => $this->front_seat_price,
            'whole_car_price' => $this->whole_car_price,
            'peak_time_price' => $this->peak_time_price,
            'tariff_id' => $this->tariff_id,
            'tariff_name' => $this->tariff?->name,
            'peak_time_start_date' => $this->peak_time_start_date,
            'peak_time_end_date' => $this->peak_time_end_date
        ];
    }
}
