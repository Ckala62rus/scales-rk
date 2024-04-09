<?php

namespace App\Http\Resources\Admin\Dashboard\InternetServiceProvider;

use Illuminate\Http\Resources\Json\JsonResource;

class InternetServiceProviderShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
