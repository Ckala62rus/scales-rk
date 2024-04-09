<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'hostname',
        'model',
        'date_buy',
        'description_service',
        'date_update',
        'operation_system',
        'cpu',
        'count_core',
        'count_core_with_ht',
        'memory',
        'hdd',
        'ssd',
        'address',
        'comment',
        'user_id',
        'organization_id',
        'equipment_id',
    ];

    /**
     * Get user model via relation
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get organization mode via relation
     * @return HasOne
     */
    public function organization(): HasOne
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    /**
     * Get equipment model via relation
     * @return HasOne
     */
    public function equipment(): HasOne
    {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }
}
