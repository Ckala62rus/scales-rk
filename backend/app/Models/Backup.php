<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'owner',
        'hostname',
        'backup_object_id',
        'backup_tool_id',
        'comment',
        'restricted_point',
        'description_storage',
        'backup_day_id',
        'time_start',
        'storage_server',
        'storage_server_long_time',
        'description_storage_long_time',
        'user_id',
        'organization_id',
        'backup_priority_id',
        'test_date',
        'proposals',
        'os_version',
    ];

    /**
     * Get organization mode via relation
     * @return HasOne
     */
    public function organization(): HasOne
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    /**
     * Get user model via relation
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get backup object model via relation
     * @return HasOne
     */
    public function backupObject(): HasOne
    {
        return $this->hasOne(BackupObject::class, 'id', 'backup_object_id');
    }

    /**
     * Get backup day model via relation
     * @return HasOne
     */
    public function backupDay(): HasOne
    {
        return $this->hasOne(BackupDay::class, 'id', 'backup_day_id');
    }

    /**
     * Get backup tool model via relation
     * @return HasOne
     */
    public function backupTool(): HasOne
    {
        return $this->hasOne(BackupTool::class, 'id', 'backup_tool_id');
    }

    /**
     * Get backup priority model via relation
     * @return HasOne
     */
    public function backupPriority(): HasOne
    {
        return $this->hasOne(BackupPriority::class, 'id', 'backup_priority_id');
    }
}
