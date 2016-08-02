<?php

namespace Galahad\LaravelAddressing\Collection;

/**
 * Interface CollectionInterface
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
interface CollectionInterface
{
    /**
     * Return all the items ready for a <select> HTML element
     *
     * @return mixed
     */
    public function toList();
}