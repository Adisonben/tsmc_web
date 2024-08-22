<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_media extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'file_name',
        'type',
        'created_by'
    ];
}
