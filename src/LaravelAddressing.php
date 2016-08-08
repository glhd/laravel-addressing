<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Intl\Country\CountryInterface;
use CommerceGuys\Intl\Exception\UnknownCountryException;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Repository\AdministrativeAreaRepository;
use Galahad\LaravelAddressing\Repository\CountryRepository;

/**
 * Class LaravelAddressing
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LaravelAddressing
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * @var CountryRepository
     */
    protected $countryRepository;

    /**
     * @var AdministrativeAreaRepository
     */
    protected $administrativeAreaRepository;

    /**
     * @var array
     */
    protected $countryList = null;

    /**
     * @var LaravelAddressing|null
     */
    private static $instance = null;

    /**
     * Constructor method
     *
     * @param string $locale
     */
    private function __construct($locale = 'en')
    {
        $this->locale = $locale;
        $this->countryRepository = new CountryRepository();
        $this->administrativeAreaRepository = new AdministrativeAreaRepository();
    }

    /**
     * Singleton instance of LaravelAddressing
     *
     * @param string $locale
     * @return LaravelAddressing
     */
    public static function getInstance($locale = 'en')
    {
        if (!static::$instance) {
            static::$instance = new static($locale);
        }

        return static::$instance;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Get a country by code
     *
     * @param $countryCode
     * @return Country|CountryInterface
     */
    public function country($countryCode)
    {
        return $this->countryRepository->get($countryCode, $this->locale);
    }

    /**
     * Get a Country instance by name
     *
     * @param $countryName
     * @return Country
     */
    public function countryByName($countryName)
    {
        $inverseCountryList = array_flip($this->getCountryList());
        if (isset($inverseCountryList[$countryName])) {
            $countryCode = $inverseCountryList[$countryName];
            return $this->country($countryCode);
        }

        throw new UnknownCountryException;
    }

    /**
     * Find a country by code or name
     *
     * @param $codeOrName
     * @return CountryInterface|Country
     */
    public function findCountry($codeOrName)
    {
        $countryList = $this->getCountryList();
        if (isset($countryList[$codeOrName])) {
            return $this->country($codeOrName);
        }
        return $this->countryByName($codeOrName);
    }

    /**
     * Return a country collection with all countries
     *
     * @return Collection\CountryCollection
     */
    public function countries()
    {
        return $this->countryRepository->getAll($this->locale);
    }

    /**
     * Get a list of all countries as a array list
     *
     * @return array
     */
    public function countriesList()
    {
        return $this->getCountryList();
    }

    /**
     * Get the country list if not loaded yet
     *
     * @return array
     */
    protected function getCountryList()
    {
        if (!$this->countryList) {
            $this->countryList = $this->countryRepository->getList($this->locale);
        }

        return $this->countryList;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return CountryRepository
     */
    public function getCountryRepository()
    {
        return $this->countryRepository;
    }

    /**
     * @return AdministrativeAreaRepository
     */
    public function getAdministrativeAreaRepository()
    {
        return $this->administrativeAreaRepository;
    }
}