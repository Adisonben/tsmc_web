<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewalCode extends Model
{
    protected $fillable = [
        'code',
        'max_uses',
        'renew_day',
        'use_per_user',
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
        return $this->usages()->groupBy('target')->count() >= $this->max_uses;
    }

    public function targetCount() {
        return $this->usages()
        ->distinct('target')
        ->count('target');
    }

    public function totalUserUsedUp($userId) {
        return $this->usages()->where('type', 'user')->where('target', $userId)->count() >= $this->use_per_user;
    }

    public function totalOrgUsedUp($orgId) {
        return $this->usages()->where('type', 'org')->where('target', $orgId)->count() >= $this->use_per_user;
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
