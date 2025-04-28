<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'name',
        'theme_color',
        'logo_img',
        'expire_at',
        'accept_terms',
        'status', // 1: Active, 0: Inactive, 2: Default
    ];
}
