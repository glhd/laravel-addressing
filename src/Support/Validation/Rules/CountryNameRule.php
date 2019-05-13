<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Contracts\Validation\Rule;

class CountryNameRule implements Rule
{
	/**
	 * @var \Galahad\LaravelAddressing\LaravelAddressing
	 */
	protected $addressing;
	
	/**
	 * Constructor
	 *
	 * @param \Galahad\LaravelAddressing\LaravelAddressing $addressing
	 */
	public function __construct(LaravelAddressing $addressing)
	{
		$this->addressing = $addressing;
	}
	
	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value) : bool
	{
		return null !== $this->addressing->countryByName($value);
	}
	
	/**
	 * @inheritDoc
	 */
	public function message() : string
	{
		return trans('laravel-addressing::validation.country_name');
	}
}
