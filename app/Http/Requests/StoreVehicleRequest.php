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

        /**
         * Get custom error messages for validation rules.
         *
         * @return array<string, string>
         */
        public function messages(): array
        {
            return [
                'license_plate.required' => 'จำเป็นต้องกรอกหมายเลขทะเบียนรถ',
                'license_plate.unique' => 'หมายเลขทะเบียนรถนี้มีอยู่ในระบบแล้ว',
                'brand.required' => 'จำเป็นต้องกรอกยี่ห้อรถ',
                'brand.max' => 'ยี่ห้อรถยาวเกินไป',
                'model.max' => 'รุ่นรถยาวเกินไป',
                'type.max' => 'ประเภทยาวเกินไป',
                'standard.max' => 'มาตรฐานยาวเกินไป',
                'ins_company.max' => 'บริษัทประกันภัยยาวเกินไป',
                'ins_type.max' => 'ประเภทประกันภัยยาวเกินไป',
                'license_category.max' => 'ประเภทใบอนุญาตขับขี่ยาวเกินไป',
                'registration_province.max' => 'จังหวัดที่จดทะเบียนยาวเกินไป',
                'license_plate.max' => 'หมายเลขทะเบียนรถยาวเกินไป',
                'license_category.string' => 'ประเภทใบอนุญาตขับขี่ต้องเป็นตัวอักษร',
                'license_plate.string' => 'หมายเลขทะเบียนรถต้องเป็นตัวอักษร',
                'registration_province.string' => 'จังหวัดที่จดทะเบียนต้องเป็นตัวอักษร',
                'brand.string' => 'ยี่ห้อรถต้องเป็นตัวอักษร',
                'model.string' => 'รุ่นรถต้องเป็นตัวอักษร',
                'type.string' => 'ประเภทต้องเป็นตัวอักษร',
                'standard.string' => 'มาตรฐานต้องเป็นตัวอักษร',
                'ins_company.string' => 'บริษัทประกันภัยต้องเป็นตัวอักษร',
                'ins_type.string' => 'ประเภทประกันภัยต้องเป็นตัวอักษร',
            ];
        }
}
