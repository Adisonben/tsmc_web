<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'has_comment',
        'has_score',
        'has_approve',
        'org',
        'form_id'
    ];
}
