<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use InvalidArgumentException;

/**
 * Class AdministrativeAreaValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidator
{
	/**
	 * The validator messages
	 *
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
			'administrative_area' => trans('laravel-addressing::validation.administrative_area'),
			'administrative_area_code' => trans('laravel-addressing::validation.administrative_area_code'),
			'administrative_area_name' => trans('laravel-addressing::validation.administrative_area_name'),
		];
	}
	
	/**
	 * Validate an Administrative Area by its code and country
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool
	 */
	public function validateAdministrativeAreaCode($attribute, $value, array $parameters, Validator $validator)
	{
		$this->validateParameterCount(1, $parameters, $attribute);
		$validator->setCustomMessages($this->messages);
		$country = $this->getCountryInstance($parameters, $validator);
		$admArea = $country->administrativeArea($value);
		
		return $admArea instanceof AdministrativeArea;
	}
	
	/**
	 * Validate an Administrative Area by its name and country
	 *
	 * @param $attribute
	 * @param $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool
	 */
	public function validateAdministrativeAreaName($attribute, $value, array $parameters, Validator $validator)
	{
		$this->validateParameterCount(1, $parameters, $attribute);
		$validator->setCustomMessages($this->messages);
		$country = $this->getCountryInstance($parameters, $validator);
		$admArea = $country->administrativeAreaByName($value);
		
		return $admArea instanceof AdministrativeArea;
	}
	
	/**
	 * Validate an administrative area trying first by code and after by name
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool
	 */
	public function validateAdministrativeArea($attribute, $value, array $parameters, Validator $validator)
	{
		$validator->setCustomMessages($this->messages);
		$codeValidation = $this->validateAdministrativeAreaCode($attribute, $value, $parameters, $validator);
		if (!$codeValidation) {
			return $this->validateAdministrativeAreaName($attribute, $value, $parameters, $validator);
		}
		
		return true;
	}
	
	/**
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
	
	/**
	 * @param $count
	 * @param array $parameters
	 * @param $rule
	 */
	protected function validateParameterCount($count, array $parameters, $rule)
	{
		if (count($parameters) !== $count) {
			throw new InvalidArgumentException("Validation rule $rule requires at least $count parameter.");
		}
	}
	
	/**
	 * Get the country instance according the parameters and values
	 *
	 * @param array $parameters
	 * @param Validator $validator
	 * @return Country|null
	 */
	private function getCountryInstance(array $parameters, Validator $validator)
	{
		$countryCodeOrName = array_get($validator->getData(), $parameters[0]);
		
		return $this->addressing->findCountry($countryCodeOrName);
	}
}
