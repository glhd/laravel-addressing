<?php

namespace Galahad\LaravelAddressing;

use ArrayObject;
use CommerceGuys\Addressing\Collection\LazySubdivisionCollection;

/**
 * Class Locality
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Locality
{
	/**
	 * @var AdministrativeArea
	 */
	protected $administrativeArea;

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
	 * @return ArrayObject
	 */
	public function getAll()
	{
		$subdivision = $this->administrativeArea->getSubdivision();
		$list = new LocalityCollection();
		$children = $subdivision->getChildren();
		/** @var LazySubdivisionCollection $child */
		foreach ($children as $child) {
			$locality = new static($this->administrativeArea);
			// TODO
			$list->insert($locality);
		}
	}
}