<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'type_code'
    ];

    public function formCategory()
    {
        return $this->belongsTo(Form_category::class, 'category');
    }
}
