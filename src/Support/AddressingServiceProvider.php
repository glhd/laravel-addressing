<?php

namespace Galahad\LaravelAddressing\Support;

use CommerceGuys\Addressing\AddressFormat\AddressFormatRepository;
use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Validator\AdministrativeAreaValidator;
use Galahad\LaravelAddressing\Validator\CountryValidator;
use Galahad\LaravelAddressing\Validator\PostalCodeValidator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AddressingServiceProvider extends ServiceProvider
{
	public function boot() : void
	{
		$this->bootRoutes();
		$this->loadTranslationsFrom(__DIR__.'/../lang', 'laravel-addressing');
		$this->publishes([
			__DIR__.'/../config/addressing.php' => config_path('addressing.php'),
		]);
	}
	
	public function register() : void
	{
		$this->app->singleton(LaravelAddressing::class, function(Application $app) {
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
	protected function bootRoutes()
	{
		if (method_exists($this->app, 'routesAreCached') && $this->app->routesAreCached()) {
			return;
		}
		
		try {
			$route = $this->app->make('router');
			$prefix = config('addressing.route.prefix', 'galahad/addressing');
			$route->group(['prefix' => $prefix], function($route) use ($prefix) {
				$route->get('/{country}/administrative-areas', [
					'as' => 'galahad.addressing.administrative-areas',
					'uses' => '\\Galahad\\LaravelAddressing\\Controller@getAdministrativeAreas',
				]);
				$route->get('/{country}/{administrativeArea}/cities', [
					'as' => 'galahad.addressing.cities',
					'uses' => '\\Galahad\\LaravelAddressing\\Controller@getCities',
				]);
				$route->get('/countries', [
					'as' => 'galahad.addressing.countries',
					'uses' => '\\Galahad\\LaravelAddressing\\Controller@getCountries',
				]);
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
