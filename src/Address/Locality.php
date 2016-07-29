<?php

namespace InterNACHI\Address;
use ArrayObject;
use CommerceGuys\Addressing\Collection\LazySubdivisionCollection;
use Illuminate\Support\Arr;

/**
 * Class Locality
 *
 * @package InterNACHI\Address
 * @author Junior Grossi <junior@internachi.org>
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
		$list = new ArrayObject();
		$children = $subdivision->getChildren();
		/** @var LazySubdivisionCollection $child */
		foreach ($children as $child) {
			$locality = new static($this->administrativeArea);
			// TODO
			$list->append($locality);
		}
	}
}