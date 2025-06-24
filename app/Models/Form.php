<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'form_id',
        'title',
        'category',
        'select_user',
        'select_vehicle',
        'has_approve',
        'org',
        'created_by',
        'status',
        'is_sub_form',
        'is_default'
    ];

    public function formCategory()
    {
        return $this->belongsTo(Form_category::class, 'category');
    }

    public function formFields()
    {
        return $this->hasMany(FormField::class, 'form_id')->orderBy('order_number');
    }

    protected $appends = ['subformfields'];

    public function getSubformfieldsAttribute()
    {
        if ($this->is_sub_form) {
            return FormField::where('form_id', $this->id)->get();
        }
        return [];
    }

    public function hasPosition() {
        return $this->hasMany(PositionHasForm::class, 'form_id');
    }

    public function hasThisPosition($positionId = null)
    {
        return $this->hasPosition()->where('position_id', $positionId)->exists();
    }

    public function countVehicleFromSubmissionByQuarter($quarter)
    {
        $quarter_start_date = now()->startOfYear()->addMonths(($quarter - 1) * 3);
        $quarter_end_date = now()->startOfYear()->addMonths((($quarter - 1) * 3) + 3)->subDay();
        if (Auth()->user()->is_tsm) {
            $org_id = session('connected_org') ?? '';
        } else {
            $org_id = Auth::user()->userDetail->org ?? '';
        }
        return $this->hasMany(FormSubmissions::class, 'form_id')
            ->where('org', $org_id)
            ->where('created_at', '>=', $quarter_start_date)
            ->where('created_at', '<=', $quarter_end_date)
            ->whereNotNull('vehicle_id')
            ->distinct('vehicle_id')
            ->count('vehicle_id');
    }

    public function countExportByQuarter($quarter) {
        $quarter_start_date = now()->startOfYear()->addMonths(($quarter - 1) * 3);
        $quarter_end_date = now()->startOfYear()->addMonths((($quarter - 1) * 3) + 3)->subDay();
        if (Auth()->user()->is_tsm) {
            $org_id = session('connected_org') ?? '';
        } else {
            $org_id = Auth::user()->userDetail->org ?? '';
        }

        return $this->hasMany(ExportPerformanceReport::class, 'form_id')
            ->where('org', $org_id)
            ->where('created_at', '>=', $quarter_start_date)
            ->where('created_at', '<=', $quarter_end_date)
            ->count();
    }
}
