<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function getOptionList()
    {
        return $this->hasMany(Option::class, 'opt_type', 'id');
    }
}
