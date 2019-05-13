<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\Entity\Country;
use Illuminate\Contracts\Validation\Rule;

class AdministrativeAreaNameRule implements Rule
{
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Country
	 */
	protected $country;
	
	/**
	 * Constructor
	 *
	 * @param \Galahad\LaravelAddressing\Entity\Country $country
	 */
	public function __construct(Country $country)
	{
		$this->country = $country;
	}
	
	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value) : bool
	{
		return null !== $this->country->administrativeAreaByName($value);
	}
	
	/**
	 * @inheritDoc
	 */
	public function message() : string
	{
		$type = $this->country->addressFormat()->getAdministrativeAreaType();
		
		return trans('laravel-addressing::validation.administrative_area_name', compact('type'));
	}
}
