<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CheckCollectionDayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path().'/Helpers/CheckCollectionDay.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
