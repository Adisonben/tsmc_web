<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsm_ai_005_data extends Model
{
    use HasFactory;

    protected $fillable = [
        "driver_name",
        "phone",
        "car_plate",
        "repair_list",
        "amount",
        "repair_type",
        "repair_by",
        "created_by",
        "org",
        "status",
    ];
}
