<?php

namespace App\Http\Requests\Backup;

use Illuminate\Foundation\Http\FormRequest;

class BackupUpdateRequest extends FormRequest
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
            'service' => 'required|string',
            'owner' => 'nullable|string',
            'hostname' => 'nullable|string',
            'backup_object_id' => 'required|integer',
            'backup_tool_id' => 'nullable|integer',
            'comment' => 'nullable|string',
            'restricted_point' => 'nullable|string',
            'description_storage' => 'nullable|string',
            'backup_day_id' => 'nullable|integer',
            'time_start' => 'nullable|string',
            'storage_server' => 'nullable|string',
            'storage_server_long_time' => 'nullable|string',
            'description_storage_long_time' => 'nullable|string',
            'organization_id' => 'required|integer',
            'backup_priority_id' => 'nullable|integer',
            'test_date' => 'nullable|string',
            'proposals' => 'nullable|string',
            'os_version' => 'nullable|string',
        ];
    }
}
