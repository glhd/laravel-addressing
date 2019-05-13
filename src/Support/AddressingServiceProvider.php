<?php

namespace Galahad\LaravelAddressing\Support;

use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Support\Http\AdministrativeAreasController;
use Galahad\LaravelAddressing\Support\Http\Controller;
use Galahad\LaravelAddressing\Support\Http\CountriesController;
use Galahad\LaravelAddressing\Validator\AdministrativeAreaValidator;
use Galahad\LaravelAddressing\Validator\CountryValidator;
use Galahad\LaravelAddressing\Validator\PostalCodeValidator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class AddressingServiceProvider extends ServiceProvider
{
	public function boot() : void
	{
		$this->bootRoutes();
		
		$this->loadTranslationsFrom(__DIR__.'/../../lang', 'laravel-addressing');
		
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/../../config/addressing.php' => $this->app->configPath('addressing.php'),
			]);
		}
	}
	
	public function register() : void
	{
		$this->mergeConfigFrom(__DIR__.'/../../config/addressing.php', 'addressing');
		
		$this->app->singleton(LaravelAddressing::class, static function(Application $app) {
			$locale = $app['config']->get('app.locale', 'en');
			$fallback_locale = $app['config']->get('app.fallback_locale', 'en');
			
			$address_format_repo = new AddressFormatRepository();
			
			return new LaravelAddressing(
				new CountryRepository($locale, $fallback_locale),
				new SubdivisionRepository($address_format_repo),
				$address_format_repo,
				$locale,
				$fallback_locale
			);
		});
		
		$this->registerValidators();
	}
	
	/**
	 * Boot routes if routing is supported
	 */
	protected function bootRoutes() : void
	{
		if ($this->app->routesAreCached()) {
			return;
		}
		
		try {
			/** @var \Illuminate\Contracts\Routing\Registrar $router */
			$router = $this->app->make('router');
			
			/** @var \Illuminate\Contracts\Config\Repository $config */
			$config = $this->app->make('config');
			
			$prefix = $config->get('addressing.route.prefix', 'galahad/addressing');
			
			$router->group(compact('prefix'), static function(Registrar $route) {
				$route->get('/countries', CountriesController::class)
					->name('galahad.addressing.countries');
				
				$route->get('/countries/{country_code}/administrative-areas', AdministrativeAreasController::class)
					->name('galahad.addressing.administrative-areas');
			});
		} catch (BindingResolutionException $exception) {
			// Skip routes if no router exists
		}
	}
	
	/**
	 * Register all custom validators
	 */
	protected function registerValidators()
	{
		$this->app->resolving('validator', function($validator, $app) {
			// Country validators
			$validator->extend('country_code', CountryValidator::class.'@validateCountryCode');
			$validator->extend('country_name', CountryValidator::class.'@validateCountryName');
			
			// Administrative Area validators
			$validator->extend(
				'administrative_area_code',
				AdministrativeAreaValidator::class.'@validateAdministrativeAreaCode'
			);
			$validator->extend(
				'administrative_area_name',
				AdministrativeAreaValidator::class.'@validateAdministrativeAreaName'
			);
			$validator->extend('administrative_area', AdministrativeAreaValidator::class.'@validateAdministrativeArea');
			
			// Postal Code validator
			$validator->extend('postal_code', PostalCodeValidator::class.'@validatePostalCode');
		});
	}
}
