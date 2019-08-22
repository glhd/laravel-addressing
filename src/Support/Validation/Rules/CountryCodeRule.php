<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Contracts\Validation\Rule;

class CountryCodeRule implements Rule
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
        if (!is_string($value)) {
            return false;
        }

		return null !== $this->addressing->country($value);
	}
	
	/**
	 * @inheritDoc
	 */
	public function message() : string
	{
		return trans('laravel-addressing::validation.country_code');
	}
}
