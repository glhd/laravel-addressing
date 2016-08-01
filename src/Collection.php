<?php

namespace Galahad\LaravelAddressing;

use ArrayObject;
use IteratorAggregate;
use Traversable;

/**
 * Class Collection
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Collection implements IteratorAggregate
{
    /**
     * @var ArrayObject
     */
    private $items;

    /**
     * The construct method
     */
    public function __construct()
    {
        $this->items = new ArrayObject();
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new Iterator($this->items);
    }

    /**
     * Insert a new element in the collection
     *
     * @param mixed $value
     */
    public function insert($value)
    {
        if (is_array($value)) {
            foreach ($value as $val) {
                $this->items->append($val);
            }
            return;
        }
        $this->items->append($value);
    }

    /**
     * Get the items count
     *
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }
}