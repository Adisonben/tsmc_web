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
        return $this->hasMany(Form::class, 'category', 'id')->where(function ($query) {
            if (Auth()->user()->is_tsm) {
                $query->where('org', session('connected_org') ?? '')->orWhere('is_default', true);
            } else {
                $query->where('org', Auth::user()->userDetail->org ?? '')->orWhere('is_default', true);
            }

        });
    }
}
