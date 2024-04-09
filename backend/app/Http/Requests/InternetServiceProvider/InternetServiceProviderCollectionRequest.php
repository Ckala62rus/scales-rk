<?php

namespace App\Http\Requests\InternetServiceProvider;

use Illuminate\Foundation\Http\FormRequest;

class InternetServiceProviderCollectionRequest extends FormRequest
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
            "internet_speed_id" => 'integer',
            "channel_type_id" => 'integer',
            "cost" => 'nullable|string',
            "static_ip_address" => 'nullable|string',
            "comment" => 'nullable|string',
        ];
    }
}
