<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'type',
        'has_comment',
        'has_score',
        'has_approve',
        'org',
        'form_id'
    ];

    public function getType()
    {
        return $this->belongsTo(Form_type::class, 'type', 'id');
    }

    public function formCategory()
    {
        return $this->belongsTo(Form_category::class, 'category');
    }
}
