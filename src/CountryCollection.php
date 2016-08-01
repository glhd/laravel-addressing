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

        if (is_array($country)) {
            foreach ($country as $c) {
                if (! $c instanceof Country) {
                    throw new Exception('All the array elements of a CountryCollection should be Country objects');
                }
            }
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
        $list = [];
        /** @var Country $element */
        foreach ($this as $element) {
            $list[$element->getCode()] = $element->getName();
        }

        return $list;
    }
}