<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prefix',
        'fname',
        'lname',
        'icon',
        'sign',
        'license',
        'dpm',
        'brn',
        'org',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrefix()
    {
        return $this->belongsTo(Prefix::class, 'prefix', 'id');
    }
}
