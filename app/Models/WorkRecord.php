<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkRecord extends Model
{
    //
    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
    ];
    public function geolocationRecords()
    {
        return $this->hasMany(GeolocationRecord::class);
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
