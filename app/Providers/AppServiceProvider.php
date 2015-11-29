<?php

namespace BookStack\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use BookStack\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Custom blade template elements
        \Blade::directive('icon', function($iconName) {
            return "<span class='icon icon-<?php echo{$iconName} ?>'> <?php echo file_get_contents(base_path('resources/assets/icons/' . with{$iconName} . '.svg')) ?></span>";
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
