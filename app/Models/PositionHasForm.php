<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionHasForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'form_type_id',
        'user_id',
        'org',
        'status'
    ];
}
