<?php

namespace App\Http\Resources\Admin\Dashboard\Scale;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ScaleCollectionResource extends JsonResource
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
            'last_error' => $this->last_error,
            'send_error_notification' => $this->send_error_notification,
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),

            'can_action' => $this->can_delete_or_update_current_user($this),
        ];
    }

    private function can_delete_or_update_current_user($backup): bool
    {
        $user = Auth::user();

        if ($user->roles->first()->name === 'super') {
            return true;
        }

        return false;
    }
}
