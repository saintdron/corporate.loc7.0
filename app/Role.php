<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany('Corp\User', 'user_role');
    }

    public function permissions()
    {
        return $this->belongsToMany('Corp\Permission', 'permission_role');
    }

    public function hasPermission($permissions, $requireAll = false)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $perm) {
                $hasPermission = $this->hasPermission($perm);
                if ($hasPermission && !$requireAll) {
                    return true;
                }
                if (!$hasPermission && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->permissions as $perm) {
                if ($permissions === $perm->name) {
                    return true;
                }
            }
        }
        return false;
    }

    public function savePermissions($array)
    {
        if (!empty($array)) {
            $this->permissions()->sync($array);
        } else {
            $this->permissions()->detach();
        }
        return true;
    }
}
