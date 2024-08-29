<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone_number extends Model
{
    use HasFactory;

    protected $fillable = [
        "person_name",
        "position",
        "office_num",
        "home_num",
        "cellphone",
        "created_by",
        "org",
    ];
}
