<?php

namespace Galahad\LaravelAddressing\Facades;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Support\Facades\Facade;

/**
 * Addressing Facade
 *
 * @mixin \Galahad\LaravelAddressing\LaravelAddressing
 */
class Addressing extends Facade
{
	/**
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return LaravelAddressing::class;
	}
}
