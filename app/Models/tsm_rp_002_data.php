<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsm_rp_002_data extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_num',
        'vehicle_plate',
        'employee_name',
        'assign_date',
        'customer_name',
        'receive_place',
        'receive_date',
        'drop_place',
        'drop_date',
        'product_volume',
        'status',
        'created_by',
        'org',
    ];
}
