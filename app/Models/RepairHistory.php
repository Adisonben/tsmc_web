<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairHistory extends Model
{
    protected $fillable = [
        'vehicle_id',
        'vehicle_plate',
        'repair_date',
        'repair_detail',
        'mileage',
        'ma_item_id',
        'repair_cost',
        'repair_operator',
        'note',
        'create_by',
        'org_id',
    ];

    public function getVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function getMaItem()
    {
        return $this->belongsTo(MaItem::class, 'ma_item_id', 'id');
    }

    public function getParts ()
    {
        return $this->hasMany(PartUse::class, 'repair_id', 'id');
    }

    public function partsTotalSum()
    {
        return $this->getParts()->sum('total_cost');
    }
}
