<?php

namespace App\Http\Requests\Scale;

use Illuminate\Foundation\Http\FormRequest;

class ScaleStoreRequest extends FormRequest
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
            'ip_address' => 'required|string|unique:App\Models\Scale,ip_address',
            'port' => 'required|numeric',
            'description' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'ip_address.required' => 'ip адрес обязателен для заполнения!',
            'ip_address.unique' => 'такой адрес уже существует!',

            'port.required' => 'порт обязателен для заполнения!',
        ];
    }
}
