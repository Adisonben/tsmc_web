<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'model',
        'plate_num',
        'gear_type',
        'car_type',
        'owner_org',
        'created_by'
    ];
}
