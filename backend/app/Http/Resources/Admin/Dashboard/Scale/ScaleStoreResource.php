<?php

namespace App\Http\Resources\Admin\Dashboard\Scale;

use Illuminate\Http\Resources\Json\JsonResource;

class ScaleStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'port' => $this->port,
            'description' => $this->description,
        ];
    }
}
