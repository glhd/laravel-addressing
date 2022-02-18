<?php

namespace Galahad\LaravelAddressing\Exceptions;

use Illuminate\Database\RecordsNotFoundException;

class CountryNotFoundException extends RecordsNotFoundException
{
	public function __construct(string $country_code)
	{
		parent::__construct("Unable to find country '{$country_code}'.");
	}
}
