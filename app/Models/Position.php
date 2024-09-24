<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Position extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'name',
        'level',
        'created_by',
        'org',
    ];

    // Define relationships
    public function permissions()
    {
        return $this->belongsToMany(Position_permission::class, 'position_has_permissions', 'position_id', 'permission_id')
            ->withPivot('user_id', 'org', 'status');
    }

    // Function to retrieve permission IDs
    public function getPermissionIds()
    {
        return $this->permissions->pluck('id')->toArray();
    }

    // Function to check if the position has a specific permission
    public function hasPermission($permissionId, $orgId = null)
    {
        $query = $this->permissions()
            ->where('permission_id', $permissionId);

        if ($orgId !== null) {
            $query->where('position_has_permissions.org', $orgId);
        } else {
            $query->whereNull('position_has_permissions.org');
        }

        return $query->first();
    }

    public function hasPermissionName($permissionName, $orgId = null)
    {
        $query = $this->permissions()
            ->where('perm_name', $permissionName);

        if ($orgId !== null) {
            $query->where('position_has_permissions.org', $orgId);
        } else {
            $query->whereNull('position_has_permissions.org');
        }
        if ($query->exists()) {
            $perm = $query->first();
        } else {
            $perm = $this->permissions()->where('perm_name', $permissionName)->whereNull('position_has_permissions.org')->first();
        }
        return $perm;
    }
}
