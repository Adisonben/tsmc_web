<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartUse extends Model
{
    protected $fillable = [
        'repair_id',
        'name',
        'quantity',
        'price',
        'total_cost',
    ];
}
