<?php

namespace App\Http\Resources\Admin\Dashboard\Device;

use App\Http\Resources\Admin\Dashboard\EquipmentShowResource;
use App\Http\Resources\Admin\Dashboard\Organization\OrganizationShowResource;
use App\Http\Resources\Admin\Dashboard\User\UserShowResource;
use App\Models\Device;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class DeviceCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this);
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
            'can_action' => $this->can_delete_or_update_current_user($this),
        ];
    }

    private function can_delete_or_update_current_user($device): bool
    {
        $user = Auth::user();

        if ($user->roles->first()->name === 'super') {
            return true;
        }

        if ($device->organization_id == $user->organization_id) {
            return true;
        }
        return false;
    }
}
