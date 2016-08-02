<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\Model\Subdivision;

/**
 * Class Locality
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Locality extends Entity
{
	/**
	 * @var AdministrativeArea
	 */
	protected $administrativeArea;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * The constructor method
	 *
	 * @param AdministrativeArea $administrativeArea
	 */
	public function __construct(AdministrativeArea $administrativeArea)
	{
		$this->administrativeArea = $administrativeArea;
	}

	/**
	 * Get all localities from a given Administrative Area
	 *
	 * @return LocalityCollection
	 */
	public function getAll()
	{
		$subdivision = $this->administrativeArea->getSubdivision();
		$list = new LocalityCollection();
		$children = $subdivision->getChildren();
		/** @var Subdivision $child */
		foreach ($children as $child) {
			$locality = new static($this->administrativeArea);
			$locality->setName($child->getName());
			$locality->setLocale($child->getLocale());
			$list->insert($locality);
		}

		return $list;
	}

	/**
	 * Get a locality by name
	 *
	 * @param $name
	 * @return Locality
	 */
	public function getByName($name)
	{
		$all = $this->getAll();
		/** @var Locality $locality */
		foreach ($all as $locality) {
			if (strtolower($locality->getName()) == strtolower($name)) {
				return $locality;
			}
		}
	}

	/**
	 * Get the locality name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the locality name
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Get the locality locale
	 *
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Set the locality locale
	 *
	 * @param string $locale
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;
	}

	/**
	 * @return AdministrativeArea
	 */
	public function getAdministrativeArea()
	{
		return $this->administrativeArea;
	}
}