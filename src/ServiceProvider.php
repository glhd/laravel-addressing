<?php

namespace Galahad\LaravelAddressing;

use Galahad\LaravelAddressing\Validator\AdministrativeAreaValidator;
use Galahad\LaravelAddressing\Validator\CountryValidator;
use Galahad\LaravelAddressing\Validator\PostalCodeValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Factory;

/**
 * Class ServiceProvider
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Booting the Service Provider
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require_once __DIR__ . '/routes.php';
        }
        $this->registerValidators($this->app->validator);
    }

    /**
     * Register the LaravelAddressing instance
     */
    public function register()
    {
        $this->app->singleton(LaravelAddressing::class, function ($app) {
            return new LaravelAddressing();
        });
    }

    /**
     * Register all custom validators
     *
     * @param Factory $validatorFactory
     */
    protected function registerValidators(Factory $validatorFactory)
    {
        // Country validators
        $validatorFactory->extend('country_code', CountryValidator::class.'@validateCountryCode');
        $validatorFactory->extend('country_name', CountryValidator::class.'@validateCountryName');
    }
}
