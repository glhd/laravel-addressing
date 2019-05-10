<?php

// FIXME: Configurable
Route::group(['prefix' => 'galahad/addressing'], function() {
	
	Route::get('/{country}/administrative-areas', [
		'as' => 'galahad.addressing.administrative-areas',
		'uses' => '\\Galahad\\LaravelAddressing\\Controller@getAdministrativeAreas',
	]);
	
	Route::get('/{country}/{administrativeArea}/cities', [
		'as' => 'galahad.addressing.cities',
		'uses' => '\\Galahad\\LaravelAddressing\\Controller@getCities',
	]);
	
	Route::get('/countries', [
		'as' => 'galahad.addressing.countries',
		'uses' => '\\Galahad\\LaravelAddressing\\Controller@getCountries',
	]);
});
