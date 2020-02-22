<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class IpgBdvPaymentResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path().'/Helpers/IpgBdvPaymentResponse.php';
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
