<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function formTypes()
    {
        return $this->hasMany(Form_type::class, 'category', 'id');
    }
}
