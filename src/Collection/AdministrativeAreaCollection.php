<?php

namespace Galahad\LaravelAddressing\Collection;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;

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
     * Shortcut for getByCode()
     *
     * @param $code
     * @return AdministrativeArea
     */
    public function code($code)
    {
        return $this->getByCode($code);
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

    /**
     * Shortcut for getByName()
     *
     * @param $name
     * @return AdministrativeArea
     */
    public function name($name)
    {
        return $this->getByName($name);
    }

    /**
     * @param int $key
     * @return AdministrativeArea
     */
    public function getByKey($key)
    {
        return parent::getByKey($key);
    }

    /**
     * Get an administrative area by code or name
     *
     * @param string $value
     * @return AdministrativeArea|null
     */
    public function getByCodeOrName($value)
    {
        return $this->getByKey(0)->getByCodeOrName($value);
    }

    /**
     * Return the list as a json string
     *
     * @return string
     */
    public function toJson()
    {
        $list = $this->toList();

        return json_encode($list);
    }
}