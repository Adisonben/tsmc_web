<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tsm_has_Org extends Model
{
    use HasFactory;

    protected $fillable = [
        'tsm_id',
        'org_id',
    ];

    public function getTSM() {
        return $this->belongsTo(User::class, 'tsm_id', 'id');
    }

    public function getOrg() {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
