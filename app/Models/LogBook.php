<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'start_mileage',
        'vehicle_plate',
        'vehicle_type',
        'org_name',
        'org_id',
        'create_by',
        'start_date',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function kmSchedules() {
        return $this->hasMany(LogBookKmSchedule::class);
    }

    public function monthSchedules() {
        return $this->hasMany(LogBookMonthSchedule::class);
    }

    public function lastMonthSchedule() {
        return $this->hasOne(LogBookMonthSchedule::class)->latestOfMany();
    }

    public function entries() {
        return $this->hasMany(LogBookEntry::class);
    }
}
