<?php

namespace Galahad\LaravelAddressing;

/**
 * Class Entity
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Entity
{
    /**
     * Get property if get method exists
     *
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        $name = array_map('ucfirst', explode('_', $name)); // some_name => ['Some', 'Name']
        $name = implode('', $name); // SomeName
        $method = 'get'.$name;
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }
}