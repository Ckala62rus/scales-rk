<?php

namespace App\Http\Requests\Backup;

use Illuminate\Foundation\Http\FormRequest;

class BackupCollectionRequest extends FormRequest
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
            "hostname" => 'nullable|string',
            "service" => 'nullable|string',
            "owner" => 'nullable|string',
            "backup_object_id" => 'nullable|integer',
            "backup_tool_id" => 'nullable|integer',
            "comment" => 'nullable|string',
            "storage_server" => 'nullable|string',
            'backup_priority_id' => 'nullable|integer',
        ];
    }
}
