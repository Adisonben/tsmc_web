<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'form_id',
        'label',
        'type', // text, number, select, subform
        'subform_id',
        'required',
        'order_number',
        'is_default'
    ];

    protected $appends = ['options', 'subform'];

    public function getOptionsAttribute()
    {
        if ($this->type == 'select') {
            return FieldOption::where('field_id', $this->id)->get();
        }
        return [];
    }

    public function getSubformAttribute()
    {
        if ($this->type == 'subform') {
            return Form::where('id', $this->subform_id)->first(['id', 'is_sub_form']);
        }
        return null;
    }

}
