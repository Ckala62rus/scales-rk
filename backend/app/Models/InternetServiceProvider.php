<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InternetServiceProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'static_ip_address',
        'schema_org_channel_provider',
        'cost_participant_1',
        'cost_participant_2',
        'cost_participant_3',
        'cost_participant_4',
        'cost_participant_5',
        'cost_participant_6',
        'comment',
        'internet_speed_id',
        'channel_type_id',
        'organization_id',
        'user_id',
        'cost',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function organization(): HasOne
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    /**
     * @return HasOne
     */
    public function channel_type(): HasOne
    {
        return $this->hasOne(ChannelType::class, 'id', 'channel_type_id');
    }

    /**
     * @return HasOne
     */
    public function internet_speed(): HasOne
    {
        return $this->hasOne(InternetSpeed::class, 'id', 'internet_speed_id');
    }
}
