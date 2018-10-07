<?php

namespace Corp\Policies;

use Corp\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Corp\User $user
     * @param  \Corp\User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->canDo('VIEW_ADMIN_USERS');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Corp\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->canDo('CREATE_USERS');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Corp\User $user
     * @param  \Corp\User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->canDo('UPDATE_USERS');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Corp\User $user
     * @param  \Corp\User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->canDo('DELETE_USERS');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Corp\User $user
     * @param  \Corp\User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Corp\User $user
     * @param  \Corp\User $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
