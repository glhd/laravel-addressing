<?php

namespace InterNACHI\Address;

use Illuminate\Support\Facades\Facade;

/**
 * Class Facade
 *
 * @package InterNACHI\Address
 * @author Junior Grossi <junior@internachi.org>
 */
class AddressFacade extends Facade
{
	protected static function getFacadeAccessor() { return 'address'; }
}