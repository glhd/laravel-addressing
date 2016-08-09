<?php

namespace Galahad\LaravelAddressing\Repository;

use Closure;
use CommerceGuys\Intl\Country\CountryRepository as BaseCountryRepository;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;

/**
 * Class CountryRepository
 *
 * @package Galahad\LaravelAddressing\Repository
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryRepository extends BaseCountryRepository
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * @param LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
        parent::__construct();
    }

    /**
     * Create Country class for LaravelAddressing package
     *
     * @param string $countryCode
     * @param array $definition
     * @param string $locale
     * @return Country
     */
    protected function createCountryFromDefinition($countryCode, array $definition, $locale)
    {
        $parentCountry = parent::createCountryFromDefinition($countryCode, $definition, $locale);
        $country = new Country($this->getAddressing(), $parentCountry);

        return $country;
    }

    /**
     * Returns a CountryCollection with Country instances
     *
     * @param null $locale
     * @param null $fallbackLocale
     * @return CountryCollection
     */
    public function getAll($locale = null, $fallbackLocale = null)
    {
    	$countries = parent::getAll($locale, $fallbackLocale);

    	return new CountryCollection($countries);
    }

    /**
     * Get the main LaravelAddressing container
     *
     * @return LaravelAddressing
     */
    public function getAddressing()
    {
        return $this->addressing;
    }

    /**
     * @param LaravelAddressing $addressing
     */
    public function setAddressing(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }
}