<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaleWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        "weight",
        'scale_id',
    ];
}
