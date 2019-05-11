<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Subdivision\Subdivision as BaseSubdivision;
use Galahad\LaravelAddressing\Collection\SubdivisionCollection;

class Subdivision
{
	/**
	 * @var \CommerceGuys\Addressing\Subdivision\Subdivision
	 */
	protected $subdivision;
	
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Country
	 */
	protected $country;
	
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Subdivision
	 */
	protected $parent;
	
	/**
	 * @var \Galahad\LaravelAddressing\Collection\SubdivisionCollection
	 */
	protected $children;
	
	public function __construct(Country $country, BaseSubdivision $subdivision, Subdivision $parent = null)
	{
		$this->subdivision = $subdivision;
		
		// parent is loaded, children is lazy loaded
		$this->country = $country;
		$this->parent = $parent;
	}
	
	public function getCountry() : Country
	{
		return $this->country;
	}
	
	public function getParent() : ?Subdivision
	{
		if (null === $this->parent && $base_parent = $this->subdivision->getParent()) {
			$this->parent = new Subdivision($this->country, $base_parent);
		}
		
		return $this->parent;
	}
	
	public function getCode() : string
	{
		return $this->subdivision->getCode();
	}
	
	public function getLocalCode() : string
	{
		return $this->subdivision->getLocalCode();
	}
	
	public function getName() : string
	{
		return $this->subdivision->getName();
	}
	
	public function getLocalName() : string
	{
		return $this->subdivision->getLocalName();
	}
	
	public function getIsoCode() : string
	{
		return $this->subdivision->getIsoCode();
	}
	
	public function getPostalCodePattern() : ?string
	{
		return $this->subdivision->getPostalCodePattern()
			?? $this->country->addressFormat()->getPostalCodePattern();
	}
	
	public function getPostalCodePatternType() : ?string
	{
		return $this->subdivision->getPostalCodePatternType();
	}
	
	public function getLocale() : string
	{
		return $this->subdivision->getLocale() ?? $this->country->getLocale();
	}
	
	public function hasChildren() : bool
	{
		return $this->subdivision->hasChildren();
	}
	
	public function getChildren() : SubdivisionCollection
	{
		if (null === $this->children) {
			$this->children = new SubdivisionCollection($this->country, $this);
			foreach ($this->subdivision->getChildren() as $child) {
				$this->children->put($child->getCode(), new Subdivision($this->country, $child, $this));
			}
		}
		
		return $this->children;
	}
	
	public function is(Subdivision $subdivision = null) : bool
	{
		if (null === $subdivision) {
			return false;
		}
		
		if (!$this->getCode() === $subdivision->getCode()) {
			return false;
		}
		
		if (!$this->getCountry()->is($subdivision->getCountry())) {
			return false;
		}
		
		if ($parent = $this->getParent()) {
			return $parent->is($subdivision->getParent());
		}
		
		return $parent === $subdivision->getParent();
	}
	
	public function __call($name, $arguments)
	{
		return $this->subdivision->$name(...$arguments);
	}
}
