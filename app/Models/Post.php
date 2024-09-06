<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'content',
        'theme_color',
        'created_by'
    ];

    public function getUser()
    {
        return $this->belongsTo(User_detail::class, 'created_by', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Post_comment::class, 'post_id', 'post_id');
    }

    public function getMedias()
    {
        return $this->hasMany(Post_media::class, 'post_id', 'id');
    }
}
