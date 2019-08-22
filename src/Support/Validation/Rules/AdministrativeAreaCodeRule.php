<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\Entity\Country;
use Illuminate\Contracts\Validation\Rule;

class AdministrativeAreaCodeRule implements Rule
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
        if (!is_string($value)) {
            return false;
        }

        return null !== $this->country->administrativeArea($value);
	}
	
	/**
	 * @inheritDoc
	 */
	public function message() : string
	{
		$type = $this->country->addressFormat()->getAdministrativeAreaType();
		
		return trans('laravel-addressing::validation.administrative_area_code', compact('type'));
	}
}
