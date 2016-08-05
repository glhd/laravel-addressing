<?php

class CountryRepository extends \CommerceGuys\Intl\Country\CountryRepository
{
	protected function createCountryFromDefinition($countryCode, array $definition, $locale)
	{
		$country = new \Galahad\Addressing\Country();
		$setValues = \Closure::bind(function ($countryCode, $definition, $locale) {
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
		}, $country, '\CommerceGuys\Intl\Country\Country');
		$setValues($countryCode, $definition, $locale);
		
		return $country;
	}
	
	public function getAll($locale = null, $fallbackLocale = null)
	{
		$countries = parent::getAll($locale, $fallbackLocale);
		return new Collection($countries);
	}
}