<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'comment',
        'form_id'
    ];

    public function columns()
    {
        return $this->belongsToMany(FormColumn::class, 'form_list_has_columns', 'list_id', 'column_id')
            ->withPivot('status');
    }

    public function hasColumn($columnId)
    {
        $query = $this->columns()
            ->where('column_id', $columnId);

        return $query->first();
    }

    public function getRecord()
    {
        return $this->hasMany(FormPlanRecord::class, 'form_list', 'id');
    }

    public function hasColumnRecord($columnId)
    {
        $query = $this->getRecord()
            ->where('form_column', $columnId);
        return $query->first();
    }
}
