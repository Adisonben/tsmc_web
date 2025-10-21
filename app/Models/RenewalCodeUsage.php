<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewalCodeUsage extends Model
{
    protected $fillable = [
        'renewal_code_id',
        'type', // user | organization
        'target', // user_id | organization_id
    ];

    public function renewalCode()
    {
        return $this->belongsTo(RenewalCode::class);
    }

    public function isUsedByUser($userId)
    {
        return $this->type === 'user' && $this->target == $userId;
    }

    public function isUsedByOrg($organizationId)
    {
        return $this->type === 'org' && $this->target == $organizationId;
    }

    public function getUser()
    {
        return $this->type === 'user' ? User::find($this->target) : null;
    }
    public function getOrganization()
    {
        return $this->type === 'org' ? Organization::find($this->target) : null;
    }

    public function getTargetName() {
        if ($this->type === 'user') {
            $user = $this->getUser();
            return $user ? $user->getFullNameAttribute() : 'Unknown User';
        } elseif ($this->type === 'org') {
            $org = $this->getOrganization();
            return $org ? $org->name : 'Unknown Organization';
        }
        return 'Unknown';
    }
}
