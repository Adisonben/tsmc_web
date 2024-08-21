<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_has_Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'permission_id'
    ];
}
