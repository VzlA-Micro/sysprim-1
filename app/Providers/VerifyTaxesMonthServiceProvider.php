<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VerifyTaxesMonthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path().'/Helpers/TaxesMonth.php';
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
