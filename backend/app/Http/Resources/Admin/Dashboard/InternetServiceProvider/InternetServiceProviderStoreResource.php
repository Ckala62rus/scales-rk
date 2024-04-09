<?php

namespace App\Http\Resources\Admin\Dashboard\InternetServiceProvider;

use App\Http\Resources\Admin\Dashboard\User\UserShowResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternetServiceProviderStoreResource extends JsonResource
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
            'address' => $this->address,
            'static_ip_address' => $this->static_ip_address,
            'schema_org_channel_provider' => $this->schema_org_channel_provider,
            'cost' => $this->cost,

            'cost_participant_1' => $this->cost_participant_1,
            'cost_participant_2' => $this->cost_participant_2,
            'cost_participant_3' => $this->cost_participant_3,
            'cost_participant_4' => $this->cost_participant_4,
            'cost_participant_5' => $this->cost_participant_5,
            'cost_participant_6' => $this->cost_participant_6,
            'comment' => $this->comment,
            'internet_speed_id' => $this->internet_speed_id,
            'channel_type_id' => $this->channel_type_id,
            'organization_id' => $this->organization_id,
            'user_id' => $this->user_id,

            'user' => UserShowResource::make($this->user)
        ];
    }
}
