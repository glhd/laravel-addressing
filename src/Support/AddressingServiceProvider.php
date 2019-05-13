<?php

namespace Galahad\LaravelAddressing\Support;

use Closure;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Support\Http\AdministrativeAreasController;
use Galahad\LaravelAddressing\Support\Http\CountriesController;
use Galahad\LaravelAddressing\Support\Validation\Validator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Contracts\Validation\Factory;
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
	 * Register our custom validators
	 */
	protected function registerValidators() : void
	{
		$this->app->resolving(Factory::class, static function(Factory $validation_factory, Container $app) {
			$validator = new Validator($app->make(LaravelAddressing::class));
			
			$validation_factory->extend('country', Closure::fromCallable([$validator, 'looseCountry']));
			$validation_factory->extend('country_code', Closure::fromCallable([$validator, 'countryCode']));
			$validation_factory->extend('country_name', Closure::fromCallable([$validator, 'countryName']));
			
			$validation_factory->extend('administrative_area', Closure::fromCallable([$validator, 'looseAdministrativeArea']));
			$validation_factory->extend('administrative_area_code', Closure::fromCallable([$validator, 'administrativeArea']));
			$validation_factory->extend('administrative_area_name', Closure::fromCallable([$validator, 'administrativeAreaName']));
			
			$validation_factory->extend('postal_code', Closure::fromCallable([$validator, 'postalCode']));
		});
	}
}
