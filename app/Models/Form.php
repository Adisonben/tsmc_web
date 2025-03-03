<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
