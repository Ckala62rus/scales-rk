<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scale extends Model
{
    use HasFactory;

    protected $fillable = [
        "ip_address",
        "port",
        "description",
        "send_error_notification",
        "last_error",
    ];

    /**
     * Get all weight for concrete scale
     *
     * @return HasMany
     */
    public function scales_weight(): HasMany
    {
        return $this->hasMany(
            ScaleWeight::class,
            'scale_id',
            'id');
    }
}
