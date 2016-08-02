<?php

namespace Galahad\LaravelAddressing;

/**
 * Class LocalityCollection
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LocalityCollection extends Collection implements CollectionInterface
{
    /**
     * Return all the items ready for a <select> HTML element
     *
     * @return mixed
     */
    public function toList()
    {
        $values = [];
        /** @var Locality $locality */
        foreach ($this as $locality) {
            $values[$locality->getName()] = $locality->getName();
        }

        return $values;
    }

    /**
     * Override the getByKey method to return the correct instance
     *
     * @param int $key
     * @return Locality
     */
    public function getByKey($key)
    {
        return parent::getByKey($key);
    }

    /**
     * Get a locality by its name
     *
     * @param $name
     * @return Locality
     */
    public function getByName($name)
    {
        if ($this->count()) {
            $locality = $this->getByKey(0);

            return $locality->getByName($name);
        }
    }
}