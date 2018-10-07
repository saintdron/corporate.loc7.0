<?php

namespace Corp\Policies;

use Corp\User;
use Corp\Slider;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the slider.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Slider  $slider
     * @return mixed
     */
    public function view(User $user, Slider $slider)
    {
        return $user->canDo('VIEW_ADMIN_SLIDERS');
    }

    /**
     * Determine whether the user can create sliders.
     *
     * @param  \Corp\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->canDo('CREATE_SLIDERS');
    }

    /**
     * Determine whether the user can update the slider.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Slider  $slider
     * @return mixed
     */
    public function update(User $user, Slider $slider)
    {
        return $user->canDo('UPDATE_SLIDERS');
    }

    /**
     * Determine whether the user can delete the slider.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Slider  $slider
     * @return mixed
     */
    public function delete(User $user, Slider $slider)
    {
        return $user->canDo('DELETE_SLIDERS');
    }

    /**
     * Determine whether the user can restore the slider.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Slider  $slider
     * @return mixed
     */
    public function restore(User $user, Slider $slider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the slider.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Slider  $slider
     * @return mixed
     */
    public function forceDelete(User $user, Slider $slider)
    {
        //
    }
}
