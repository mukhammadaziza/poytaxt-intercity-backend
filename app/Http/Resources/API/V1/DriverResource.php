<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'address' => $this->address,
            'status' => $this->status,
            'gender' => $this->gender?->name,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'balance' => $this->balance,
            'car' => $this->whenLoaded('car', function ($car) {
                return [
                    'id' => $car->id,
                    'plate_number' => $car->plate_number,
                    'technical_pass_number' => $car->technical_pass_number,
                    'production_year' => $car->production_year,
                    'car_model' => [
                        'id' => $car->carModel?->id,
                        'name' => $car->carModel?->name,
                    ],
                ];
            }),
            'tariffs' => $this->whenLoaded('tariffs', function () {
                return $this->tariffs->map(function ($tariff) {
                    return [
                        'id' => $tariff->id,
                        'name' => $tariff->name,
                        'number_of_seats' => $tariff->number_of_seats,
                        'description' => $tariff->description,
                    ];
                });
            }),
            'profile' => $this->whenLoaded('profile', function () {
                return [
                    'id' => $this->profile->id,
                    'pool' => $this->profile->pool?->name,
                    'status' => $this->profile->status?->name,
                    'driver_balance' => $this->profile?->driver_balance,
                    'commission_type' => $this->profile?->commission_type->name,
                    'commission_value' => $this->profile?->commission_value,
                ];
            }),
        ];
    }
}
