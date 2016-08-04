<?php

/*

-> /galahad/addressing/US/adminstrative-areas
<- {
     "label": "State",
     "expected_length": 2,
	 "options": {
        "AL": "Alabama"
     }
   }

*/

Route::group(['prefix' => 'galahad/addressing'], function() {

	Route::get('/{country}/administrative-areas', [
		'as' => 'galahad.addressing.administrative-areas',
		'uses' => '\\Galahad\\LaravelAddressing\\Controller@getAdministrativeAreas'
	]);

});