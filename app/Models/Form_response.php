<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_response extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_data',
        'user_id',
        'form_id',
        'times',
        'status',
        'score',
        'totalScore'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
