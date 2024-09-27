<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'form_id',
        'group_id',
        'option_type',
    ];

    public function questionGroup()
    {
        return $this->belongsTo(Quest_group::class, 'group_id');
    }

    public function getOption()
    {
        return $this->belongsTo(Option_type::class, 'option_type', 'id');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'question_id', 'id');
    }
}
