<?php

namespace Galahad\LaravelAddressing\Support\Facades;

use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Galahad\LaravelAddressing\Entity\Country|null country($country_code, $locale = null)
 * @method static CountryCollection countries($locale = null)
 * @method static array countryList()
 * @method static \Galahad\LaravelAddressing\Entity\Country|null countryByName($name)
 * @method static \Galahad\LaravelAddressing\Entity\Country|null findCountry($input)
 */
class Addressing extends Facade
{
	protected static function getFacadeAccessor() : string
	{
		return LaravelAddressing::class;
	}
}
