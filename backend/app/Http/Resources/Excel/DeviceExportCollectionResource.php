<?php

namespace App\Http\Resources\Excel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceExportCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'organization' => $this->organization->name,
            'equipment' => $this->equipment->name,
            'hostname' => $this->hostname,
            'model' => $this->model,
            'description_service' => $this->description_service,
            'operation_system' => $this->operation_system,
            'cpu' => $this->cpu,
            'count_core' => $this->count_core,
            'count_core_with_ht' => $this->count_core_with_ht,
            'memory' => $this->memory,
            'hdd' => $this->hdd,
            'ssd' => $this->ssd,
            'address' => $this->address,
            'comment' => $this->comment,
            'date_buy' => $this->date_buy,
            'date_update' => $this->date_update,
            'user' => $this->user->email,
        ];
    }
}
