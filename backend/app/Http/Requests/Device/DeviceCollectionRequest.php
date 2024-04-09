<?php

namespace App\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class DeviceCollectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'limit' => 'required|integer',
            "organization_id" => 'integer',
            "equipment_id" => 'integer',
            "hostname" => 'nullable|string',
            "model" => 'nullable|string',
            "operation_system" => 'nullable|string',
            "description_service" => 'nullable|string',
            "cpu" => 'nullable|string',
            "comment" => 'nullable|string',
        ];
    }
}
