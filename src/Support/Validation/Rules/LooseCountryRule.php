<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Contracts\Validation\Rule;

class LooseCountryRule implements Rule
{
	/**
	 * @var \Galahad\LaravelAddressing\LaravelAddressing
	 */
	protected $addressing;

	/**
	 * @var Rule
	 */
	protected $matched_rule;

	/**
	 * Constructor.
	 *
	 * @param \Galahad\LaravelAddressing\LaravelAddressing $addressing
	 */
	public function __construct(LaravelAddressing $addressing)
	{
		$this->addressing = $addressing;
	}

	/**
	 * {@inheritdoc}
	 */
	public function passes($attribute, $value): bool
	{
		return (new CountryCodeRule($this->addressing))->passes($attribute, $value)
            ?: (new CountryNameRule($this->addressing))->passes($attribute, $value);
	}

	/**
	 * {@inheritdoc}
	 */
	public function message(): string
	{
		return trans('laravel-addressing::validation.country');
	}
}
