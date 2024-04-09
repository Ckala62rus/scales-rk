<?php

namespace App\Http\Resources\Admin\Dashboard\InternetServiceProvider;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class InternetServiceProviderCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'organization' => $this->organization->name,
            'internet_speed_id' => $this->internet_speed_id,
            'internet_speed_name' => $this->internet_speed ? $this->internet_speed->name : null,
            'address' => $this->address,
            'comment' => $this->comment,
            'channel_type_id' => $this->channel_type_id,
            'channel_type' => $this->channel_type->name,
            'static_ip_address' => $this->static_ip_address,
            'schema_org_channel_provider' => $this->schema_org_channel_provider,
            'cost' => $this->cost,

            'cost_participant_1' => $this->cost_participant_1,
            'cost_participant_2' => $this->cost_participant_2,
            'cost_participant_3' => $this->cost_participant_3,
            'cost_participant_4' => $this->cost_participant_4,
            'cost_participant_5' => $this->cost_participant_5,
            'cost_participant_6' => $this->cost_participant_6,

            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
            'user_id' => $this->user_id,

            'can_action' => $this->can_delete_or_update_current_user($this),
        ];
    }

    private function can_delete_or_update_current_user($backup): bool
    {
        $user = Auth::user();

        if ($user->roles->first()->name === 'super') {
            return true;
        }

        if ($backup->organization_id == $user->organization_id) {
            return true;
        }
        return false;
    }
}
