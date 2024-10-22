<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quest_group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'form_id',
        'title',
        'group_type',
        'content'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'group_id', 'id')->withTrashed();
    }

    public function answers()
    {
        return $this->hasMany(Form_answer::class, 'quest_group_id', 'id');
    }

    public function getAnswers($respId = "")
    {
        $query = $this->answers()
        ->where('resp_id', $respId);

        return $query->exists();
    }
}
