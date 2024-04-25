<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $scale_id
 * @property int $weight
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class ScaleWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        "weight",
        'scale_id',
    ];

    /**
     * Get parent model from scale model
     *
     * @return HasOne
     */
    public function scale() : HasOne
    {
        return $this->hasOne(
            Scale::class,
            'id',
            'scale_id'
        );
    }
}
