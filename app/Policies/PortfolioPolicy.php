<?php

namespace Corp\Policies;

use Corp\User;
use Corp\Portfolio;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the portfolio.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Portfolio  $portfolio
     * @return mixed
     */
    public function view(User $user, Portfolio $portfolio)
    {
        return $user->canDo('VIEW_ADMIN_PORTFOLIOS');
    }

    /**
     * Determine whether the user can create portfolios.
     *
     * @param  \Corp\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->canDo('CREATE_PORTFOLIOS');
    }

    /**
     * Determine whether the user can update the portfolio.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Portfolio  $portfolio
     * @return mixed
     */
    public function update(User $user, Portfolio $portfolio)
    {
        return $user->canDo('UPDATE_PORTFOLIOS');
    }

    /**
     * Determine whether the user can delete the portfolio.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Portfolio  $portfolio
     * @return mixed
     */
    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->canDo('DELETE_PORTFOLIOS');
    }

    /**
     * Determine whether the user can restore the portfolio.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Portfolio  $portfolio
     * @return mixed
     */
    public function restore(User $user, Portfolio $portfolio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the portfolio.
     *
     * @param  \Corp\User  $user
     * @param  \Corp\Portfolio  $portfolio
     * @return mixed
     */
    public function forceDelete(User $user, Portfolio $portfolio)
    {
        //
    }
}
