<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // @set($i,10)
        Blade::directive('set', function ($exp) {
            list($name, $val) = explode(',', $exp);
            return "<?php $name = $val ?>";
        });

        /*        DB::listen(function ($query) {
                    dump($query->sql);
                });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
