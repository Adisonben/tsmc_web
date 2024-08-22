<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Position extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'level',
        'created_by',
        'org'
    ];
}
