<?php

namespace App\Http\Resources\Admin\Dashboard\ScaleWeight;

use App\Models\ScaleWeight;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScaleWeightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ScaleWeight $this */

        return [
            'id' => $this->id,
            'scale_id' => $this->scale_id,
            'weight' => $this->weight,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
