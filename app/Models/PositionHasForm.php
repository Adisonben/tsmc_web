<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionHasForm extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'form_id',
    ];
}
