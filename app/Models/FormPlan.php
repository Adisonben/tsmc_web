<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_data',
        'user_id',
        'form_id',
        'status'
    ];

    public function getUser()
    {
        return $this->belongsTo(User_detail::class, 'user_id', 'user_id');
    }

    public function getForm()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
