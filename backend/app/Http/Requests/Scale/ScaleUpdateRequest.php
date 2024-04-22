<?php

namespace App\Http\Requests\Scale;

use Illuminate\Foundation\Http\FormRequest;

class ScaleUpdateRequest extends FormRequest
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
            'ip_address' => 'required|string',
            'port' => 'required|numeric',
            'description' => 'nullable',
        ];
    }
}
