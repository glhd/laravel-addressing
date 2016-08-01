<?php

namespace Galahad\LaravelAddressing;

use Exception;

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
     * @throws Exception
     */
    public function insert($country)
    {
        if ($country instanceof Country) {
            return parent::insert($country);
        }
        throw new Exception('You can only insert Country objects in a CountryCollection');
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