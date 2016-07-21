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
		
		// Or register Blade directives?
	}
	
	public function register()
	{
		
	}
}
