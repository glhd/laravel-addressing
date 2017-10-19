<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;

/**
 * Class PostalCodeValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidator
{
	/**
	 * @var array
	 */
	protected $messages = [];
	
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
		$this->messages = [
			'postal_code' => trans('laravel-addressing::validation.postal_code'),
		];
	}
	
	/**
	 * Validate a postal code using country and administrative area fields
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool|int
	 */
	public function validatePostalCode($attribute, $value, array $parameters, Validator $validator)
	{
		$validator->setCustomMessages($this->messages);

		if (!$country = $this->getCountryInstance($parameters, $validator)) {
		    return true;
        }

        $postalCodePattern = $country->getPostalCodePattern();

        if ($area = $this->getAdministrativeAreaInstance($country, $parameters, $validator)) {
            $postalCodePattern = $area->getPostalCodePattern();
        }

        if (!$postalCodePattern) {
		    return true;
        }

        return 1 === preg_match("/^$postalCodePattern/", $value);
	}
	
	/**
	 * Get the country instance according the parameters and values
	 *
	 * @param array $parameters
	 * @param Validator $validator
	 * @return Country|null
	 */
	protected function getCountryInstance(array $parameters, Validator $validator)
	{
		$key = isset($parameters[0]) ? $parameters[0] : 'country';
		$countryCodeOrName = array_get($validator->getData(), $key);
		
		return $this->addressing->findCountry($countryCodeOrName);
	}
	
	/**
	 * Get the administrative area instance according the parameters and values
	 *
	 * @param Country $country
	 * @param array $parameters
	 * @param Validator $validator
	 * @return AdministrativeArea|null
	 */
	protected function getAdministrativeAreaInstance(Country $country, array $parameters, Validator $validator)
	{
		$keys = ['administrative_area', 'state'];
		if (isset($parameters[1])) {
			array_unshift($keys, $parameters[1]);
		}
		
		foreach ($keys as $key) {
			if ($value = array_get($validator->getData(), $key)) {
				return $country->findAdministrativeArea($value);
			}
		}
	}
}
