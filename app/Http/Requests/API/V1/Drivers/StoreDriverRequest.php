<?php

namespace App\Http\Requests\API\V1\Drivers;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'gender' => ['nullable', 'integer'],
            'phone' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth' => ['required', 'date'],

            'tariff_ids' => ['required', 'array', 'min:1'],
            'tariff_ids.*' => ['integer', 'exists:tariffs,id'],

            'car_model_id' => ['required', 'integer', 'exists:car_models,id'],
            'plate_number' => ['required', 'string'],
            'technical_pass_number' => ['required', 'string'],
            'production_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],

            'pool_id' => ['required', 'integer', 'exists:pools,id'],
            'commission_type' => ['nullable', 'integer'],
            'commission_value' => ['nullable', 'numeric'],
        ];
    }
}
