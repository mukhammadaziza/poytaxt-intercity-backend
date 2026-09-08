<?php

namespace App\Http\Requests\API\V1\Cars;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'car_model_id' => ['required'],
            'plate_number' => ['required'],
            'technical_pass_number' => ['required'],
            'production_year' => ['required']
        ];
    }
}
