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
}