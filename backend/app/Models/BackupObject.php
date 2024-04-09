<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'backup_object_id',
    ];
}
