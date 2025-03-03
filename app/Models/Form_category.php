<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Form_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function getForms()
    {
        return $this->hasMany(Form::class, 'category', 'id')->where('org', Auth::user()->userDetail->org ?? '');
    }
}
