<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resp_id',
        'quest_id',
        'answer',
        'comment'
    ];
}
