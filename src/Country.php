<?php

namespace Galahad\LaravelAddressing;

use ArrayObject;
use CommerceGuys\Addressing\Repository\CountryRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;

/**
 * Class Country
 *
 * Usage:
 *
 * $country = new Country;
 * echo $country->findByName('brazil')->getCode();
 * echo $country->findByCode('br')->getName();
 * $allCountries = $country->getAll(); // Return an ArrayObject with Country objects
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Country
{
	/**
	 * @var string|null
	 */
	protected $code;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 */
	protected $parentId;

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * @var null|ArrayObject
	 */
	protected $administrativeAreas = null;

	/**
	 * @var CountryRepository|null
	 */
	protected $countryRepository = null;

	/**
	 * @var SubdivisionRepository|null
	 */
	protected $subdivisionRepository = null;

	/**
	 * Construct method
	 */
	public function __construct()
	{
		$this->countryRepository = new CountryRepository();
		$this->subdivisionRepository = new SubdivisionRepository();
	}

	/**
	 * Return the name field
	 *
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the name field
	 *
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Get the code field
	 *
	 * @return null
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set the code field
	 *
	 * @param null $code
	 */
	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * Get the parentId field
	 *
	 * @return int
	 */
	public function getParentId()
	{
		return $this->parentId;
	}

	/**
	 * Set the parentId field
	 *
	 * @param int $parentId
	 */
	public function setParentId($parentId)
	{
		$this->parentId = $parentId;
	}

	/**
	 * Get the locale field
	 *
	 * @return null|string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Set the locale field
	 *
	 * @param string $locale
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;
	}

	/**
	 * Get the AddressFormatRepository instance
	 *
	 * @return Address|null
	 */
	public function getAddressFormatRepository()
	{
		return $this->addressFormatRepository;
	}

	/**
	 * Get the CountryRepository instance
	 *
	 * @return CountryRepository|null
	 */
	public function getCountryRepository()
	{
		return $this->countryRepository;
	}

	/**
	 * Get the SubdivisionRepository instance
	 *
	 * @return SubdivisionRepository|null
	 */
	public function getSubdivisionRepository()
	{
		return $this->subdivisionRepository;
	}

	/**
	 * Get all countries
	 *
	 * @return CountryCollection
	 */
	public function getAll()
	{
		$countries = $this->countryRepository->getList($this->locale);
		$list = new CountryCollection();
		foreach ($countries as $code => $name) {
			$country = new static;
			$country->setName($name);
			$country->setCode($code);
			$country->setLocale($this->locale);
			$list->insert($country);
		}

		return $list;
	}

	/**
	 * Get a country by any field
	 *
	 * @param $fieldName
	 * @param $fieldValue
	 * @return Country|null
	 */
	protected function getByField($fieldName, $fieldValue)
	{
		$fieldValue = strtolower($fieldValue);
		$list = static::getAll();
		/** @var Country $country */
		foreach ($list as $country) {
			$method = 'get'.ucfirst($fieldName);
			$objectValue = strtolower($country->$method());
			if ($objectValue == $fieldValue) {
				return $country;
			}
		}

		return null;
	}

	/**
	 * Get a country instance by the code
	 *
	 * @param $code
	 * @return Country|null
	 */
	public function getByCode($code)
	{
		return $this->getByField('code', $code);
	}

	/**
	 * Shortcut for the getByCode() method
	 *
	 * @param $code
	 * @return Country|null
	 */
	public function code($code)
	{
		return $this->getByCode($code);
	}

	/**
	 * Get a country instance by the name
	 *
	 * @param $name
	 * @return Country|null
	 */
	public function getByName($name)
	{
		return $this->getByField('name', $name);
	}

	/**
	 * Get all the administrative areas from a given country
	 *
	 * @return AdministrativeAreaCollection
	 */
	public function getAdministrativeAreas()
	{
		if (is_null($this->administrativeAreas)) {
			$admArea = new AdministrativeArea($this);
			$this->administrativeAreas = $admArea->getAll();
		}

		return $this->administrativeAreas;
	}

	/**
	 * Shortcut for getAdministrativeAreas() method
	 *
	 * @return AdministrativeAreaCollection
	 */
	public function states()
	{
		return $this->getAdministrativeAreas();
	}

	/**
	 * Shortcut to get a state from a country
	 *
	 * @param $code
	 * @return AdministrativeArea
	 */
	public function state($code)
	{
		$state = $this->getAdministrativeAreas()->getByCode($code);
		if ($state instanceof AdministrativeArea) {
			return $state;
		}
		$state = $this->getAdministrativeAreas()->getByName($code);
		if ($state instanceof AdministrativeArea) {
			return $state;
		}
	}
}