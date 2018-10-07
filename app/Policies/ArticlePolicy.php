<?php

namespace Corp\Policies;

use Corp\User;
use Corp\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the article.
     *
     * @param  \Corp\User $user
     * @param  \Corp\Article $article
     * @return mixed
     */
    public function view(User $user, Article $article)
    {
        return $user->canDo('VIEW_ADMIN_ARTICLES');
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \Corp\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->canDo('CREATE_ARTICLES');
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \Corp\User $user
     * @param  \Corp\Article $article
     * @return mixed
     */
    public function update(User $user, Article $article)
    {
//        return $user->id === $article->user_id && $user->canDo('UPDATE_ARTICLES');
        return $user->canDo('UPDATE_ARTICLES');
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \Corp\User $user
     * @param  \Corp\Article $article
     * @return mixed
     */
    public function delete(User $user, Article $article)
    {
//        return $user->id === $article->user_id && $user->canDo('DELETE_ARTICLES');
        return $user->canDo('DELETE_ARTICLES');
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \Corp\User $user
     * @param  \Corp\Article $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \Corp\User $user
     * @param  \Corp\Article $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
