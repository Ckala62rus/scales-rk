<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string ip_address
 * @property int $port
 * @property string $description
 * @property boolean $send_error_notification
 * @property string last_error
 * @property DateTime last_error_date
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Scale extends Model
{
    use HasFactory;

    protected $fillable = [
        "ip_address",
        "port",
        "description",
        "send_error_notification",
        "last_error",
        "last_error_date",
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
