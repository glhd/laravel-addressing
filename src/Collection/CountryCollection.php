<?php

namespace Galahad\LaravelAddressing\Collection;

use Galahad\LaravelAddressing\Entity\Country;
use Illuminate\Support\Collection;

class CountryCollection extends Collection
{
    /**
     * @return \Galahad\LaravelAddressing\Entity\Country[]
     */
    public function all() : array
    {
        return parent::all();
    }

    public function get($key, $default = null) : ?Country
    {
        return parent::get($key, $default);
    }

    public function keys() : Collection
    {
        return new Collection(array_keys($this->items));
    }

    public function last(callable $callback = null, $default = null) : ?Country
    {
        return parent::last($callback, $default);
    }

    public function pop() : ?Country
    {
        return parent::pop();
    }

    /**
     * @param \Galahad\LaravelAddressing\Entity\Country $value
     * @param null $key
     * @return \Galahad\LaravelAddressing\Collection\CountryCollection
     */
    public function prepend($value, $key = null) : self
    {
        return parent::prepend($value, $key);
    }

    public function pull($key, $default = null) : ?Country
    {
        return parent::pull($key, $default);
    }

    /**
     * @param mixed $key
     * @param Country $value
     * @return \Galahad\LaravelAddressing\Collection\CountryCollection
     */
    public function put($key, $value) : self
    {
        return parent::put($key, $value);
    }

    /**
     * @return \Galahad\LaravelAddressing\Entity\Country[]
     */
    public function toArray() : array
    {
        return parent::toArray();
    }

    public function toSelectArray() : array
    {
        return $this->mapWithKeys(static function (Country $country) {
            return [$country->getCountryCode() => $country->getName()];
        })->toArray();
    }

    public function offsetGet($key) : ?Country
    {
        return parent::offsetGet($key);
    }

    /**
     * @param mixed $key
     * @param \Galahad\LaravelAddressing\Entity\Country $value
     */
    public function offsetSet($key, $value) : void
    {
        parent::offsetSet($key, $value);
    }
}
