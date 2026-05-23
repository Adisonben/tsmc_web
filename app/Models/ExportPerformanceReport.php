<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportPerformanceReport extends Model
{
    protected $fillable = [
        'user_id',
        'form_id',
        'quarter',
        'org',
        'accepted'
    ];

    protected $casts = [
        'accepted' => 'boolean',
    ];
}
