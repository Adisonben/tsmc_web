<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_media extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'folder',
        'file_name',
        'originalName',
        'type',
        'size_kb',
        'extension',
        'created_by'
    ];

    public function getPost()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
