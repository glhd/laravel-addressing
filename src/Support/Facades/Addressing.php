<?php

namespace Galahad\LaravelAddressing\Support\Facades;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Support\Facades\Facade;

// TODO: PHPDoc @static methods

class Addressing extends Facade
{
	protected static function getFacadeAccessor() : string
	{
		return LaravelAddressing::class;
	}
}
