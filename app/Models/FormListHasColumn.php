<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormListHasColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'list_id',
        'column_id',
        'status'
    ];
}
