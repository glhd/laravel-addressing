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
    protected $countryRepository = null;

    /**
     * @var AdministrativeAreaRepository
     */
    protected $administrativeAreaRepository = null;

    /**
     * @var array
     */
    protected $countryList = null;

    /**
     * Constructor method
     *
     * @param string $locale
     */
    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    /**
     * Get a country by code
     *
     * @param $countryCode
     * @return Country|CountryInterface
     */
    public function country($countryCode)
    {
        return $this->getCountryRepository()->get($countryCode, $this->locale);
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
        return $this->getCountryRepository()->getAll($this->locale);
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
            $this->countryList = $this->getCountryRepository()->getList($this->locale);
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
    	if (!$this->countryRepository) {
		    $this->countryRepository = new CountryRepository($this);
	    }
	    
        return $this->countryRepository;
    }

    /**
     * @return AdministrativeAreaRepository
     */
    public function getAdministrativeAreaRepository()
    {
    	if (!$this->administrativeAreaRepository) {
    		$this->administrativeAreaRepository = new AdministrativeAreaRepository();
	    }
	    
        return $this->administrativeAreaRepository;
    }
}