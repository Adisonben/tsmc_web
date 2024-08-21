<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
