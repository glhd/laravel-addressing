<?php

namespace InterNACHI\Address;

use ArrayObject;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;

/**
 * Class AdministrativeArea
 *
 * @package InterNACHI\Address
 * @author Junior Grossi <junior@internachi.org>
 */
class AdministrativeArea
{
	/**
	 * @var Country|null
	 */
	protected $country = null;

	/**
	 * @var null|string
	 */
	protected $code = null;

	/**
	 * @var null|string
	 */
	protected $name = null;

	/**
	 * @var SubdivisionRepository|null
	 */
	protected $subdivisionRepository;

	/**
	 * Construct method
	 *
	 * @param Country|string $country
	 */
	public function __construct($country)
	{
		if ($country instanceof Country) {
			$this->country = $country;
		} elseif (is_string($country)) {
			$object = new Country;
			$this->country = $object->findByCode($country);
		}

		$this->subdivisionRepository = $this->getCountry()->getSubdivisionRepository();
	}

	/**
	 * Get all administrative areas from a given country
	 *
	 * @return ArrayObject
	 */
	public function getAll()
	{
		$country = $this->getCountry();
		$repo = $country->getSubdivisionRepository();
		$list = new ArrayObject;
		foreach ($repo->getList($country->getCode()) as $code => $name) {
			$admArea = new static($country);
			$admArea->setCode($code);
			$admArea->setName($name);
			$list->append($admArea);
		}

		return $list;
	}

	/**
	 * Get an administrative area by field and value
	 *
	 * @param $fieldName
	 * @param $fieldValue
	 * @return AdministrativeArea
	 */
	protected function findByField($fieldName, $fieldValue)
	{
		$fieldValue = strtolower($fieldValue);
		$list = $this->getAll();
		/** @var AdministrativeArea $admArea */
		foreach ($list as $admArea) {
			$method = 'get'.ucfirst($fieldName);
			if (strtolower($admArea->$method()) == $fieldValue) {
				return $admArea;
			}
		}
	}

	/**
	 * Get an administrative area by code
	 *
	 * @param $code
	 * @return AdministrativeArea
	 */
	public function findByCode($code)
	{
		return $this->findByField('code', $code);
	}

	/**
	 * Get an administrative area by name
	 *
	 * @param $name
	 * @return AdministrativeArea
	 */
	public function findByName($name)
	{
		return $this->findByField('name', $name);
	}
	
	/**
	 * Get the country instance
	 *
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Set the country instance
	 *
	 * @param Country|null $country
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;
	}

	/**
	 * Get the administrative area code
	 *
	 * @return null
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set the administrative area code
	 *
	 * @param null $code
	 */
	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * Get the administrative area name
	 *
	 * @return null
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the administrative area name
	 *
	 * @param null $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return SubdivisionRepository|null
	 */
	public function getSubdivisionRepository()
	{
		return $this->subdivisionRepository;
	}
}