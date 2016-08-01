<?php

namespace Galahad\LaravelAddressing;

/**
 * Class CountryCollection
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryCollection extends Collection implements CollectionInterface
{
    /**
     * Insert method for Country objects
     *
     * @param mixed $country
     */
    public function insert(Country $country)
    {
        return parent::insert($country);
    }

    /**
     * Return all the items ready for a <select> HTML element
     *
     * @return mixed
     */
    public function toList()
    {
        // TODO
    }
}