<?php

namespace InterNACHI\Address;

class Address
{
	/**
	 * @var string|null
	 */
	protected $locale;

	/**
	 * @var Country
	 */
	protected $country;

	/**
	 * Constructor method
	 *
	 * @param string|null $locale
	 */
	public function __construct($locale = null)
	{
		$this->locale = $locale;
		$this->country = new Country;
		$this->country->setLocale($locale);
	}

	/**
	 * Get the country list
	 *
	 * @return ArrayObject
	 */
	public function getCountries()
	{
		return $this->country->getAll();
	}

	/**
	 * Get a country by code
	 *
	 * @param $code
	 * @return Country|null
	 */
	public function findCountryByCode($code)
	{
		return $this->country->findByCode($code);
	}

	/**
	 * Get a country by name
	 *
	 * @param $name
	 * @return Country|null
	 */
	public function findCountryByName($name)
	{
		return $this->country->findByName($name);
	}
}