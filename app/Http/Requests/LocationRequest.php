<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        return [
            'location_code' => 'required|string|max:50|unique:locations,location_code,' . ($this->location_id ?? 'NULL') . ',location_id',
            'location_name' => 'required|string|max:100',
            'location_type' => 'required|in:store,warehouse,display_case,safe,vault,counter,workshop,qc_area,quarantine',
            'parent_location_id' => 'nullable|integer|exists:locations,location_id',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
            'capacity' => 'nullable|integer',
            'temperature_controlled' => 'required|boolean',
            'humidity_controlled' => 'required|boolean',
            'security_level' => 'required|in:low,medium,high,maximum',
            'notes' => 'nullable|string',
        ];
    }
}
