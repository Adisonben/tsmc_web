<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewalCode extends Model
{
    protected $fillable = [
        'code',
        'max_uses',
        'expires_at',
    ];

    public function usages()
    {
        return $this->hasMany(RenewalCodeUsage::class);
    }
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at < now();
    }
    public function isUsedUp()
    {
        return $this->usages()->count() >= $this->max_uses;
    }

    public function isUseByUser($userId)
    {
        return $this->usages()->where('type', 'user')->where('target', $userId)->exists();
    }
    public function isUseByOrg($orgId)
    {
        return $this->usages()->where('type', 'org')->where('target', $orgId)->exists();
    }
}
