<?php

namespace Galahad\LaravelAddressing\Repository;

use Closure;
use CommerceGuys\Intl\Country\CountryRepository as BaseCountryRepository;
use Galahad\LaravelAddressing\Entity\Country;

/**
 * Class CountryRepository
 *
 * @package Galahad\LaravelAddressing\Repository
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryRepository extends BaseCountryRepository
{
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
        $country = new Country();
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

}