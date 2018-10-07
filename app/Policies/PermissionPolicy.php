<?php

namespace Corp\Policies;

use Corp\User;
use Corp\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the permission.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Permission  $permission
     * @return mixed
     */
    public function view(User $user, Permission $permission)
    {
        return $user->canDo('VIEW_ADMIN_PERMISSIONS');
    }

    /**
     * Determine whether the user can create permissions.
     *
     * @param  \Corp\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the permission.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Permission  $permission
     * @return mixed
     */
    public function update(User $user, Permission $permission)
    {
        return $user->canDo('EDIT_PERMISSIONS');
    }

    /**
     * Determine whether the user can delete the permission.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Permission  $permission
     * @return mixed
     */
    public function delete(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can restore the permission.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Permission  $permission
     * @return mixed
     */
    public function restore(User $user, Permission $permission)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the permission.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Permission  $permission
     * @return mixed
     */
    public function forceDelete(User $user, Permission $permission)
    {
        //
    }
}
