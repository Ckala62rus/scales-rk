<?php

namespace App\Http\Resources\Admin\Dashboard\Scale;

use App\Http\Resources\Admin\Dashboard\ScaleWeight\ScaleWeightResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScaleShowResource extends JsonResource
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
            'ip_address' => $this->ip_address,
            'port' => $this->port,
            'description' => $this->description,
            'last_error' => $this->last_error,
            'send_error_notification' => $this->send_error_notification,
            'details' => ScaleWeightResource::collection($this->scales_weight),
        ];
    }
}
