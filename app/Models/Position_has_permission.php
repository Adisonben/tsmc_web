<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position_has_permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'permission_id',
        'user_id',
        'org',
        'status'
    ];
}
