<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Model\Subdivision;

/**
 * Class AdministrativeArea
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeArea extends Subdivision
{
	/**
	 * @param Subdivision $subdivision
	 */
	public function __construct(Subdivision $subdivision)
	{
		$this->copyPropertiesFromBaseClass($subdivision);
	}
	
	/**
	 * @param Subdivision $subdivision
	 */
	protected function copyPropertiesFromBaseClass(Subdivision $subdivision)
	{
		foreach (get_object_vars($subdivision) as $key => $value) {
			$this->$key = $value;
		}
	}
}
