<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmissionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'user_id',
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id');
    }
}
