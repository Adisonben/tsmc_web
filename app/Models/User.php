<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'username',
        'password',
        'pass_text'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userDetail()
    {
        return $this->hasOne(User_detail::class);
    }

    public function getFullNameAttribute()
    {
        return $this->userDetail ? ($this->userDetail->getPrefix->name ?? '') . $this->userDetail->fname . ' ' . $this->userDetail->lname : '';
    }

    public function getCitizenIdAttribute()
    {
        return $this->userDetail ? $this->userDetail->citizen_id : '';
    }

    public function getOrgNameAttribute()
    {
        return $this->userDetail ? $this->userDetail->getOrg?->name : '';
    }
}
