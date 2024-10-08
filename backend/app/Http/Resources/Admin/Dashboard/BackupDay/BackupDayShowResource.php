<?php

namespace App\Http\Resources\Admin\Dashboard\BackupDay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BackupDayShowResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
