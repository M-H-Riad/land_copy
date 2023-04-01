<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

         Schema::defaultStringLength(191);

        /*
           |--------------------------------------------------------------------------
           | Extend blade so we can define a variable
           | <code>
           | @set(name, value)
           | </code>
           |--------------------------------------------------------------------------
        */

        Blade::directive('set', function($expression) {
            list($name, $val) = explode(',', $expression);
            return "<?php {$name} = {$val}; ?>";
        });

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
