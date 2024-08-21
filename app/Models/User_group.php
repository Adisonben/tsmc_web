<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Group.php
    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_has_groups');
    // }
}
