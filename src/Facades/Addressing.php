<?php

namespace Galahad\LaravelAddressing\Facades;

use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Support\Facades\Facade;

/**
 * Addressing Facade
 *
 * @package Galahad\LaravelAddressing
 * @mixin \Galahad\LaravelAddressing\LaravelAddressing
 */
class Addressing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelAddressing::class;
    }
}
