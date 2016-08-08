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
        $country = new Country($this->getAddressing());
        $setValues = Closure::bind(function ($countryCode, $definition, $locale) {
            $this->countryCode = $countryCode;
            $this->name = $definition['name'];
            $this->locale = $locale;
            if (isset($definition['three_letter_code'])) {
                $this->threeLetterCode = $definition['three_letter_code'];
            }
            if (isset($definition['numeric_code'])) {
                $this->numericCode = $definition['numeric_code'];
            }
            if (isset($definition['currency_code'])) {
                $this->currencyCode = $definition['currency_code'];
            }
        }, $country, '\Galahad\LaravelAddressing\Entity\Country');
        $setValues($countryCode, $definition, $locale);

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
        $locale = $this->resolveLocale($locale, $fallbackLocale);
        $definitions = $this->loadDefinitions($locale);
        $countries = new CountryCollection();
        foreach ($definitions as $countryCode => $definition) {
            $country = $this->createCountryFromDefinition($countryCode, $definition, $locale);
            $countries->push($country);
        }

        return $countries;
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