<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $vehicleId = $this->route('id');
        return [
            'license_category' => 'nullable|string|max:255',
            'license_plate' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicleId),
            ],
            'registration_province' => 'nullable|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'standard' => 'nullable|string|max:255',
            'ins_company' => 'nullable|string|max:255',
            'ins_type' => 'nullable|string|max:255',
        ];
    }
}
