<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPlanRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "form_id",
        "form_column",
        "form_list",
        "times",
        "is_finish",
        "form_plan_id",
    ];
}
