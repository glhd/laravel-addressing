<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use InterNACHI\Address\Address;

class AddressServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('address', function ($app) {
            return new Address();
        });
    }
}
