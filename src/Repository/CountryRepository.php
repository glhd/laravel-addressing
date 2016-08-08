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
    	// TODO See Country::__construct2()
	    // TODO It might be nice to do return new Country(parent::createCountryFromDefinition(...))
	    // TODO And that makes this a little more future-proof
	    // TODO Not sure if it'd work, though, and if there are any particular performance bottlenecks
    	
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