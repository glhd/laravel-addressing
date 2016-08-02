<?php

namespace Galahad\LaravelAddressing;

/**
 * Class AdministrativeAreaCollection
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaCollection extends Collection implements CollectionInterface
{
    /**
     * Return all the items ready for a <select> HTML element
     *
     * @return mixed
     */
    public function toList()
    {
        $items = [];
        /** @var AdministrativeArea $area */
        foreach ($this as $area) {
            $items[$area->getCode()] = $area->getName();
        }

        return $items;
    }

    /**
     * Get an administrative are by code
     *
     * @param string $code
     * @return AdministrativeArea
     */
    public function getByCode($code)
    {
        /** @var AdministrativeArea $first */
        $first = $this->getByKey(0);

        return $first->getByCode($code);
    }

    /**
     * Get an administrative are by name
     *
     * @param string $name
     * @return AdministrativeArea
     */
    public function getByName($name)
    {
        $first = $this->getByKey(0);

        return $first->getByName($name);
    }
}