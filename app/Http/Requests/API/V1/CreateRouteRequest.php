<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRouteRequest extends FormRequest
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
            'driver_id' => ['required'],
            'from_location_id' => ['required'],
            'to_location_id' => ['required'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'occupied_seats' => ['nullable'],
            'details' => ['nullable']
        ];
    }
}
