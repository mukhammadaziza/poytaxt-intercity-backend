<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'car_model_id' => $this->whenLoaded('carModel'),
            'plate_number' => $this->plate_number,
            'technical_pass_number' => $this->technical_pass_number,
            'production_year' => $this->production_year
        ];
    }
}
