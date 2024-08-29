<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'opt_text',
        'score',
        'opt_type'
    ];

    public function getOptionType()
    {
        return $this->belongsTo(Option_type::class, 'opt_type');
    }
}
