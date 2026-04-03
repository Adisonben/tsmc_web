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

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'org_id', 'id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            User_detail::class,
            'org', // Foreign key on user_details table
            'id', // Foreign key on users table
            'id', // Local key on organizations table
            'user_id' // Local key on user_details table
        );
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'org', 'id');
    }
}
