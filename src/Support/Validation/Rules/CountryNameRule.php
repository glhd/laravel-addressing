<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class CountryNameRule implements Rule
{
	/**
	 * @var \Galahad\LaravelAddressing\LaravelAddressing
	 */
	protected $addressing;

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
		try {
			$value = (string) $value;
		} catch (Throwable $exception) {
			return false;
		}

		return null !== $this->addressing->countryByName($value);
	}

	/**
	 * {@inheritdoc}
	 */
	public function message(): string
	{
		return trans('laravel-addressing::validation.country_name');
	}
}
