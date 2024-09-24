<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsm_v_002_data extends Model
{
    use HasFactory;

    protected $fillable = [
        "driver_name",
        "car_id",
        "car_plate",
        "car_type",
        "car_model",
        "order_num",
        "repair_type",
        "mileage",
        "cost_amount",
        "create_by",
        "org",
        "status",
    ];

    public function getRepairList()
    {
        return $this->hasMany(Repair_history_data::class, 'order_num', 'order_num');
    }
}
