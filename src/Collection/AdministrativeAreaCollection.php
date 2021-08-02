<?php

namespace Galahad\LaravelAddressing\Collection;

use Galahad\LaravelAddressing\Entity\Subdivision;

class AdministrativeAreaCollection extends SubdivisionCollection
{
	/**
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea[]
	 */
	public function all(): array
	{
		return parent::all();
	}
	
	/**
	 * @param string $key
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea|null $default
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function get($key, $default = null): ?Subdivision
	{
		return parent::get($key, $default);
	}
	
	/**
	 * @param callable|null $callback
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea $default
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function last(callable $callback = null, $default = null): ?Subdivision
	{
		return parent::last($callback, $default);
	}
	
	/**
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function pop(): ?Subdivision
	{
		return parent::pop();
	}
	
	/**
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea $value
	 * @param null $key
	 * @return \Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection
	 */
	public function prepend($value, $key = null): SubdivisionCollection
	{
		return parent::prepend($value, $key);
	}
	
	/**
	 * @param string $key
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea|null $default
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function pull($key, $default = null): ?Subdivision
	{
		return parent::pull($key, $default);
	}
	
	/**
	 * @param string $key
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea $value
	 * @return \Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection
	 */
	public function put($key, $value): SubdivisionCollection
	{
		return parent::put($key, $value);
	}
	
	/**
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea[]
	 */
	public function toArray(): array
	{
		return parent::toArray();
	}
	
	/**
	 * @param string $key
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function offsetGet($key): ?Subdivision
	{
		return parent::offsetGet($key);
	}
	
	/**
	 * @param string $key
	 * @param \Galahad\LaravelAddressing\Entity\AdministrativeArea $value
	 */
	public function offsetSet($key, $value): void
	{
		parent::offsetSet($key, $value);
	}
}
