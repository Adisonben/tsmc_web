<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'title',
        'group_type',
        'content'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'group_id', 'id');
    }
}
