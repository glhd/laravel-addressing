<?php

namespace Galahad\LaravelAddressing\Entity;

use BadMethodCallException;
use Exception;
use Illuminate\Support\Str;

trait DecoratesEntity
{
	public function __call($name, $arguments)
	{
		return $this->decoratedEntity()->$name(...$arguments);
	}
	
	public function __get($name)
	{
		$method = 'get'.Str::studly($name);
		
		// First try on the entity itself, in case we've overridden the method
		if (method_exists($this, $method)) {
			return $this->{$method}();
		}
		
		// Then defer to the underlying decorated entity
		if (method_exists($this->decoratedEntity(), $method)) {
			return $this->decoratedEntity()->{$method}();
		}
		
		throw new Exception("Unknown attribute: '{$name}' (no '{$method}' exists)");
	}
	
	public function __set($name, $value)
	{
		throw new BadMethodCallException('Addressing entity attributes are read-only.');
	}
	
	public function __isset($name)
	{
		$method = 'get'.Str::studly($name);
		
		return method_exists($this, $method) || method_exists($this->decoratedEntity(), $method);
	}
	
	abstract protected function decoratedEntity();
}
