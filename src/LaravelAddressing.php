<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\Country;

/**
 * Class LaravelAddressing
 *
 * @todo Get rid of all "city" code
 *
 * @todo Addressing::country($code)
 * @todo Addressing::countryByName($name)
 * @todo Addressing::findCountry($codeOrName)
 * @todo Addressing::countries()
 * @todo Addressing::setLocale()
 * @todo Addressing::getLocale()
 * @todo Addressing::country($code)->administrativeAreas()
 * @todo Addressing::country('US')->administrativeArea($code)
 *
 * @todo Galahad\Addressing\Repository\CountryRepository
 * @todo Galahad\Addressing\Repository\CountryRepository::setContainer()
 * @todo Galahad\Addressing\Repository\AdminsitrativeAreaRepository
 * @todo Galahad\Addressing\Repository\AdminsitrativeAreaRepository::setContainer()
 *
 * @todo See https://laravel.com/docs/5.2/collections
 * @todo Galahad\Addressing\Collection\CountryCollection
 * @todo Galahad\Addressing\Collection\CountryCollection::setContainer()
 * @todo Galahad\Addressing\Collection\AdminsitrativeAreaCollection
 * @todo Galahad\Addressing\Collection\AdminsitrativeAreaCollection::setContainer()
 *
 * @todo Galahad\Addressing\Country::setContainer() -> sets $this->app — or maybe do via constructor
 * @todo Galahad\Addressing\Country::administrativeArea($code) -> $this-app->addressing->getAdministrativeAreasRepository()->get($code, $code)
 * @todo Galahad\Addressing\Country::administrativeAreas()
 *
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LaravelAddressing
{
    const ARRAY_LIST = 1;

    /**
     * @var SubdivisionRepository
     */
    protected $subdivisionRepository;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var null|string
     */
    protected $locale;

    /**
     * The construct method
     *
     * @param string|null $locale
     */
    public function __construct($locale = null)
    {
        $this->locale = $locale;
        $this->subdivisionRepository = new SubdivisionRepository(); // TODO: Why not lazy-load with getSubdivisionRepository()
        $this->country = new Country($locale); // TODO: Seems like this should do the same, with a getCountryRepository() method
    }

    /**
     * Get the country by code
     *
     * @param $code
     * @return Country|null
     */
    public function getCountryByCode($code)
    {
        return $this->country->getByCode($code);
    }

    /**
     * Get a country by its name
     *
     * @param $name
     * @return Country
     */
    public function getCountryByName($name)
    {
        return $this->country->getByName($name);
    }

    /**
     * Get a country by code or by name
     *
     * @param string $value
     * @return Country|null
     */
    public function getCountryByCodeOrName($value)
    {
        return $this->country->getByCodeOrName($value);
    }

    /**
     * Shortcut to getCountryByCode() method
     *
     * @param $code
     * @return Country|null
     */
    public function country($code)
    {
        return $this->getCountryByCode($code);
    }

    /**
     * Get the countries list
     *
     * Example:
     * $addressing = new LaravelAddressing;
     * return $addressing->countries(LaravelAddressing::ARRAY_LIST);
     *
     * @param int $asArrayList
     * @return CountryCollection|array
     */
    public function getCountries($asArrayList = 0)
    {
    	// TODO: I think this is unnecessary since we have the toList() (to be refactored as toArray()) method
        if ($asArrayList === static::ARRAY_LIST) {
            return $this->country->getAll()->toList();
        }

        return $this->country->getAll();
    }

    /**
     * Shortcut for getCountries() method
     *
     * @param int $asArrayList
     * @return array|CountryCollection
     */
    public function countries($asArrayList = 0)
    {
        return $this->getCountries($asArrayList);
    }

    /**
     * Get the locale
     *
     * @return null|string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the default locale
     *
     * @param null|string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->country->setLocale($locale);
    }

    /**
     * Get all the administrative areas by country code
     *
     * @param string $countryCode
     * @return AdministrativeAreaCollection
     */
    public function getAdministrativeAreas($countryCode)
    {
    	
    }

    /**
     * Get the SubdivisionRepository instance
     *
     * @return SubdivisionRepository
     */
    protected function getSubdivisionRepository()
    {
        if (!isset($this->subdivisionRepository)) {
            $this->subdivisionRepository = new SubdivisionRepository();
        }

        return $this->subdivisionRepository;
    }

    /**
     * TODO
     */
    protected function getAddressFormatRepository()
    {
        // TODO
    }
}