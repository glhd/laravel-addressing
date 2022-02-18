<?php

namespace Galahad\LaravelAddressing\Exceptions;

use Illuminate\Database\RecordsNotFoundException;

class AdministrativeAreaNotFoundException extends RecordsNotFoundException
{
	public function __construct(string $country_code, string $administrative_area_code)
	{
		parent::__construct("Unable to find administrative area '{$administrative_area_code}' in country '{$country_code}'.");
	}
}
