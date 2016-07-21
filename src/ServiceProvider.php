<?php

namespace Galahad\LaravelAddressing;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function boot()
	{
		if (!$this->app->routesAreCached()) {
			require_once __DIR__.'/routes.php';
		}
		
		// Perhaps offer address views
		// $this->loadViewsFrom(__DIR__.'/views', 'laravel-addressing');
		
		$this->registerValidators();
	}
	
	public function register()
	{
		$this->app->singleton(LaravelAddressing::class, function($app) {
			return new LaravelAddressing();
		});
	}
	
	protected function registerValidators()
	{
		
		/*
		
		Example:
		
		$this->validate($request, [
			'display_name' => 'required|maxlen:255',
			'country' => 'required|len:2|country_code',
			'state' => 'administrative_area:country',
			'postal' => 'postal_code:country,state'
		]);
		
		 */
		
		Validator::extend('country_code', function($attribute, $value, $parameters, $validator) {
			
		});
		
		Validator::extend('country_name', function($attribute, $value, $parameters, $validator) {
			
		});
		
		Validator::extend('administrative_area', function($attribute, $value, $parameters, $validator) {
			
		});
		
		Validator::extend('postal_code', function($attribute, $value, $parameters, $validator) {
			
		});
	}
}
