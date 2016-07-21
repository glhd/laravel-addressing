<?php

Route::group(['prefix' => 'galahad/addressing'], function() {

	Route::get('/{country}/administrative-areas', [
		'as' => 'galahad.addressing.administrative-areas',
		'uses' => '\\Galahad\\LaravelAddressing\\AddressingController@getAdministrativeAreas'
	]);
	
});