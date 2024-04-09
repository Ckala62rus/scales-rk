<?php

namespace App\Http\Resources\Excel;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupExportCollectionResource extends JsonResource
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
            'organization' => $this->organization->name,
            'service' => $this->service,
            'owner' => $this->owner,
            'hostname' => $this->hostname,
            'object' => $this->object,
            'tool' => $this->tool,
            'bd' => $this->bd,
            'restricted_point' => $this->restricted_point,
            'type' => $this->type,
            'day' => $this->day,
            'time_start' => $this->time_start,
            'storage_server' => $this->storage_server,
            'storage_long_time' => $this->storage_long_time,
            'description_storage_long_time' => $this->description_storage_long_time,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
