<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Subdivision\Subdivision as BaseSubdivision;

/**
 * @method getParent()
 * @method string getCountryCode()
 * @method string getLocale()
 * @method string getCode()
 * @method string getLocalCode()
 * @method string getName()
 * @method string getLocalName()
 * @method string getIsoCode()
 * @method string getPostalCodePattern()
 * @method string getPostalCodePatternType()
 * @method getChildren()
 * @method bool hasChildren()
 */
class Subdivision
{
	/**
	 * @var \CommerceGuys\Addressing\Subdivision\Subdivision
	 */
	protected $subdivision;
	
	public function __construct(BaseSubdivision $subdivision)
	{
		$this->subdivision = $subdivision;
	}
	
	public function __call($name, $arguments)
	{
		return $this->subdivision->$name(...$arguments);
	}
}
