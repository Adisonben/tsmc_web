<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'license_category',
        'license_plate',
        'registration_province',
        'brand',
        'model',
        'type',
        'standard',
        'ins_company',
        'ins_type',
        'org_id'
    ];

    protected $appends = ['driver_id'];

    public function getAssignment()
    {
        return $this->hasOne(VehicleAssignment::class, 'vehicle_id', 'id');
    }

    public function getDriverIdAttribute()
    {
        $assignment = $this->hasOne(VehicleAssignment::class, 'vehicle_id', 'id')->first();
        if ($assignment) {
            return $assignment->user_id;
        }
        return null;
    }
}
