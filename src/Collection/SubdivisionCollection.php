<?php

namespace Galahad\LaravelAddressing\Collection;

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Entity\Subdivision;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SubdivisionCollection extends Collection
{
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Country
	 */
	protected $country;
	
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Subdivision
	 */
	protected $parent;
	
	public function setCountry(Country $country) : self
	{
		$this->country = $country;
		
		return $this;
	}
	
	public function getCountry() : Country
	{
		return $this->country;
	}
	
	public function setParent(Subdivision $parent) : self
	{
		$this->parent = $parent;
		
		return $this;
	}
	
	public function getParent() : ?Subdivision
	{
		return $this->parent;
	}
	
	/**
	 * @return \Galahad\LaravelAddressing\Entity\Subdivision[]
	 */
	public function all() : array
	{
		return parent::all();
	}
	
	public function get($key, $default = null) : ?Subdivision
	{
		return parent::get($key, $default);
	}
	
	public function keys() : Collection
	{
		return new Collection(array_keys($this->items));
	}
	
	public function last(callable $callback = null, $default = null) : ?Subdivision
	{
		return parent::last($callback, $default);
	}
	
	public function pop() : ?Subdivision
	{
		return parent::pop();
	}
	
	/**
	 * @param \Galahad\LaravelAddressing\Entity\Subdivision $value
	 * @param null $key
	 * @return \Galahad\LaravelAddressing\Collection\SubdivisionCollection
	 */
	public function prepend($value, $key = null) : self
	{
		return parent::prepend($value, $key);
	}
	
	public function pull($key, $default = null) : ?Subdivision
	{
		return parent::pull($key, $default);
	}
	
	/**
	 * @param mixed $key
	 * @param Subdivision $value
	 * @return \Galahad\LaravelAddressing\Collection\SubdivisionCollection
	 */
	public function put($key, $value) : self
	{
		return parent::put($key, $value);
	}
	
	/**
	 * @return \Galahad\LaravelAddressing\Entity\Subdivision[]
	 */
	public function toArray() : array
	{
		return parent::toArray();
	}
	
	public function offsetGet($key) : ?Subdivision
	{
		return parent::offsetGet($key);
	}
	
	/**
	 * @param mixed $key
	 * @param \Galahad\LaravelAddressing\Entity\Subdivision $value
	 */
	public function offsetSet($key, $value) : void
	{
		parent::offsetSet($key, $value);
	}
}
