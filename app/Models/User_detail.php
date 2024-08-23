<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prefix',
        'fname',
        'lname',
        'icon',
        'sign',
        'license',
        'dpm',
        'brn',
        'org',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrefix()
    {
        return $this->belongsTo(Prefix::class, 'prefix', 'id');
    }

    public function getDpm()
    {
        return $this->belongsTo(Department::class, 'dpm', 'id');
    }
    public function getBrn()
    {
        return $this->belongsTo(Branch::class, 'brn', 'id');
    }
    public function getOrg()
    {
        return $this->belongsTo(Organization::class, 'org', 'id');
    }

    public function getPosition()
    {
        return $this->belongsTo(Position::class, 'position', 'id');
    }
}
