<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'form_id',
        'user_id',
        'vehicle_id',
        'submitted_by',
        'status',
        'org'
    ];

    public function getForm()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select('id');
    }

    public function getVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }

    public function getSubmissionValues()
    {
        return $this->hasMany(FormSubmissionValue::class, 'submission_id');
    }

    public function getSubmissionHistory()
    {
        return $this->hasMany(FormSubmissionHistory::class, 'submission_id')->orderByDesc('created_at')->limit(10);
    }

    public function getSubmissionValuesIsNull()
    {
        return $this->hasMany(FormSubmissionValue::class, 'submission_id')->whereNull('value');
    }

    public function getFieldValue ($fieldId) {
        return $this->getSubmissionValues()->where('field_id', $fieldId)->first();
    }
}
