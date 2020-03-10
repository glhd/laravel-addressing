<?php

/** @noinspection SenselessProxyMethodInspection */
/** @noinspection ReturnTypeCanBeDeclaredInspection */

namespace Galahad\LaravelAddressing\Support\Facades;

use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Support\Facades\Facade;

class Addressing extends Facade
{
    /**
     * {@inheritdoc}
     * @return \Galahad\LaravelAddressing\LaravelAddressing
     */
    public static function getFacadeRoot()
    {
        return parent::getFacadeRoot();
    }

    /**
     * Get a country by 2-letter ISO code.
     *
     * @param string $country_code
     * @param string|null $locale
     * @return \Galahad\LaravelAddressing\Entity\Country
     */
    public static function country($country_code, $locale = null): ?Country
    {
        return static::getFacadeRoot()->country($country_code, $locale);
    }

    /**
     * Get all countries as a collection.
     *
     * @param string|null $locale
     * @return \Galahad\LaravelAddressing\Collection\CountryCollection
     */
    public static function countries($locale = null): CountryCollection
    {
        return static::getFacadeRoot()->countries($locale);
    }

    /**
     * Load a country by its full name.
     *
     * @param string $name
     * @return \Galahad\LaravelAddressing\Entity\Country|null
     */
    public static function countryByName($name): ?Country
    {
        return static::getFacadeRoot()->countryByName($name);
    }

    /**
     * Find a country, either by code or by name.
     *
     * @param string $input
     * @return \Galahad\LaravelAddressing\Entity\Country|null
     */
    public static function findCountry($input): ?Country
    {
        return static::getFacadeRoot()->findCountry($input);
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return LaravelAddressing::class;
    }
}
