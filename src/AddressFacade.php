<?php

namespace Galahad\LaravelAddressing;

use Illuminate\Support\Facades\Facade;

/**
 * Class AddressFacade
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AddressFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return LaravelAddressing::class;
	}
}
