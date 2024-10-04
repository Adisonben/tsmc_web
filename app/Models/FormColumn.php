<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'group_name',
        'form_id'
    ];
}
