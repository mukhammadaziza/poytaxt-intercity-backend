<?php

namespace App\Http\Requests\API\V1\Users;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'phone' => ['required', 'string', 'regex:/^\+998\d{9}$/'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'date_of_birth' => ['required', 'date'],
            'role_ids'   => ['required', 'array', 'min:1'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ];
    }
}
