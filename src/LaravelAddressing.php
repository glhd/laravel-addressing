<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\Country;

/**
 * Class LaravelAddressing
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
        $this->subdivisionRepository = new SubdivisionRepository();
        $this->country = new Country($locale);
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
    }

    public function getAdministrativeAreas($countryCode)
    {
        $repo = $this->getSubdivisionRepository();

        return $repo->getAll($countryCode);
    }

    protected function getSubdivisionRepository()
    {
        if (!isset($this->subdivisionRepository)) {
            $this->subdivisionRepository = new SubdivisionRepository();
        }

        return $this->subdivisionRepository;
    }

    protected function getAddressFormatRepository()
    {
        // TODO
    }
}