<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
