<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'org_id'
    ];

    public function getOrg()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
