<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Intl\Country\CountryInterface;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Repository\AdministrativeAreaRepository;
use Galahad\LaravelAddressing\Repository\CountryRepository;

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
     * Constructor method
     *
     * @param string $locale
     */
    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
        $this->countryRepository = new CountryRepository();
        $this->administrativeAreaRepository = new AdministrativeAreaRepository();
    }

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