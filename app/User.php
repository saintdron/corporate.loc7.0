<?php

namespace Corp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles()
    {
        return $this->hasMany('Corp\Article');
    }

    public function comments()
    {
        return $this->hasMany('Corp\Comment');
    }

    public function roles()
    {
        return $this->belongsToMany('Corp\Role', 'user_role');
    }

    public function canDo($permissions, $requireAll = false)
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                $hasPermission = $this->canDo($permission);
                if ($hasPermission && !$requireAll) {
                    return true;
                }
                if (!$hasPermission && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                foreach ($role->permissions as $perm) {
                    if (str_is($permissions, $perm->name)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function hasRole($roles, $requireAll = false)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $hasRole = $this->hasRole($role);
                if ($hasRole && !$requireAll) {
                    return true;
                }
                if (!$hasRole && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                if (str_is($roles, $role->name)) {
                    return true;
                }
            }
        }
        return false;
    }
}
