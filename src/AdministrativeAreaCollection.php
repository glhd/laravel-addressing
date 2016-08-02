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
    public function findByCode($code)
    {
        /** @var AdministrativeArea $first */
        $first = $this->getByKey(0);

        return $first->findByCode($code);
    }

    /**
     * Get an administrative are by name
     *
     * @param string $name
     * @return AdministrativeArea
     */
    public function findByName($name)
    {
        $first = $this->getByKey(0);

        return $first->findByName($name);
    }
}