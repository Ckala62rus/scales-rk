<?php

namespace App\Http\Requests\InternetServiceProvider;

use Illuminate\Foundation\Http\FormRequest;

class InternetServiceProviderUpdateRequest extends FormRequest
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
            'organization_id' => 'sometimes|integer',
            'channel_type_id' => 'sometimes|integer',
            'address' => 'sometimes|string',
            'static_ip_address' => 'nullable|string',
            'schema_org_channel_provider' => 'nullable|string',
            'cost' => 'nullable|string',
            'cost_participant_1' => 'nullable|string',
            'cost_participant_2' => 'nullable|string',
            'cost_participant_3' => 'nullable|string',
            'cost_participant_4' => 'nullable|string',
            'cost_participant_5' => 'nullable|string',
            'cost_participant_6' => 'nullable|string',
            'comment' => 'nullable|string',
            'internet_speed_id' => 'nullable|integer',
        ];
    }
}
