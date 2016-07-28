<?php

namespace InterNACHI\Address;

/**
 * Class Facade
 *
 * @package InterNACHI\Address
 * @author Junior Grossi <junior@internachi.org>
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
	protected static function getFacadeAccessor() { return 'address'; }
}