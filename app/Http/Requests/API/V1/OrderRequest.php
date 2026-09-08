<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_type' => ['required'],
            'tariff_id' => ['required'],
            'departure_time' => ['required'],
            'from_location_id' => ['required'],
            'to_location_id' => ['required'],
            'phone_1' => ['required'],
            'phone_2' => ['nullable'],
            'number_of_people' => ['nullable'],
            'seats' => ['nullable'],
            'whole_car' => ['nullable'],
            'extra_services' => ['nullable'],
            'comment' => ['nullable'],
            'total_price' => ['nullable'],
        ];
    }
}
