<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Corp\Article' => 'Corp\Policies\ArticlePolicy',
        'Corp\Permission' => 'Corp\Policies\PermissionPolicy',
        'Corp\Menu' => 'Corp\Policies\MenuPolicy',
        'Corp\User' => 'Corp\Policies\UserPolicy',
        'Corp\Portfolio' => 'Corp\Policies\PortfolioPolicy',
        'Corp\Slider' => 'Corp\Policies\SliderPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW__ADMIN', function ($user) {
            return $user->canDo('VIEW__ADMIN');
        });
    }
}
