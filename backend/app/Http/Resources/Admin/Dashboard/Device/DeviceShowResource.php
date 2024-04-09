<?php

namespace App\Http\Resources\Admin\Dashboard\Device;

use App\Http\Resources\Admin\Dashboard\EquipmentShowResource;
use App\Http\Resources\Admin\Dashboard\Organization\OrganizationShowResource;
use App\Http\Resources\Admin\Dashboard\User\UserShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceShowResource extends JsonResource
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
            'hostname' => $this->hostname,
            'model' => $this->model,
            'date_buy' => $this->date_buy,
            'description_service' => $this->description_service,
            'date_update' => $this->date_update,
            'operation_system' => $this->operation_system,
            'cpu' => $this->cpu,
            'count_core' => $this->count_core,
            'count_core_with_ht' => $this->count_core_with_ht,
            'memory' => $this->memory,
            'hdd' => $this->hdd,
            'ssd' => $this->ssd,
            'address' => $this->address,
            'comment' => $this->comment,

            'user_id' => $this->user_id,
            'user' => UserShowResource::make($this->user),

            'organization_id' => $this->organization_id,
            'organization' => OrganizationShowResource::make($this->organization),

            'equipment_id' => $this->equipment_id,
            'equipment' => EquipmentShowResource::make($this->equipment),

        ];
    }
}
