<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair_history_data extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_num",
        "repair_type",
        "repair_by",
        "spare_part",
        "cost",
    ];
}
