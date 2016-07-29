<?php

namespace InterNACHI\Address;

use ArrayObject;
use CommerceGuys\Addressing\Model\Subdivision;

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
	 * Construct method
	 *
	 * @param Country $country
	 */
	public function __construct(Country $country)
	{
		$this->country = $country;
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
		/** @var Subdivision $area */
		foreach ($repo->getList($country->getCode()) as $code => $name) {
			$admArea = new static($country);
			$admArea->setCode($code);
			$admArea->setName($name);
			$list->append($admArea);
		}

		return $list;
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
}