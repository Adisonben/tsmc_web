<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position_permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'perm_name',
        'label',
        'org'
    ];
}
