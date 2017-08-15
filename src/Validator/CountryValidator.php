<?php

namespace Galahad\LaravelAddressing\Validator;

use CommerceGuys\Intl\Exception\UnknownCountryException;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;

/**
 * Class CountryValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidator
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
	 * The constructor method
	 *
	 * @param LaravelAddressing $addressing
	 */
	public function __construct(LaravelAddressing $addressing)
	{
		$this->addressing = $addressing;
		$this->messages = [
			'country_name' => trans('laravel-addressing::validation.country_name'),
			'country_code' => trans('laravel-addressing::validation.country_code'),
		];
	}
	
	/**
	 * Validate a country by its name
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool
	 */
	public function validateCountryName($attribute, $value, array $parameters, Validator $validator)
	{
		$validator->setCustomMessages($this->messages);
		
		try {
			return $this->addressing->countryByName($value) instanceof Country;
		} catch (UnknownCountryException $exception) {
			return false;
		}
	}
	
	/**
	 * Validate a country by its code
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param array $parameters
	 * @param Validator $validator
	 * @return bool
	 */
	public function validateCountryCode($attribute, $value, array $parameters, Validator $validator)
	{
		$validator->setCustomMessages($this->messages);
		
		try {
			return $this->addressing->country($value) instanceof Country;
		} catch (UnknownCountryException $exception) {
			return false;
		}
	}
}
