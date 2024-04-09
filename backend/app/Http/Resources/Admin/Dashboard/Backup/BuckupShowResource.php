<?php

namespace App\Http\Resources\Admin\Dashboard\Backup;

use Illuminate\Http\Resources\Json\JsonResource;

class BuckupShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'backup_day_id' => $this->backup_day_id,
            'backup_object_id' => $this->backup_object_id,
            'backup_priority_id' => $this->backup_priority_id ? $this->backup_priority_id : 0,
            'backup_tool_id' => $this->backup_tool_id,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'description_storage' => $this->description_storage,
            'description_storage_long_time' => $this->description_storage_long_time,
            'hostname' => $this->hostname,
            'organization_id' => $this->organization_id,
            'owner' => $this->owner,
            'restricted_point' => $this->restricted_point,
            'service' => $this->service,
            'storage_server' => $this->storage_server,
            'storage_server_long_time' => $this->storage_server_long_time,
            'time_start' => $this->time_start,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'test_date' => $this->test_date,
            'proposals' => $this->proposals,
            'os_version' => $this->os_version,
        ];
    }
}
