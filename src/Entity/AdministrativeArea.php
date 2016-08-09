<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Collection\LazySubdivisionCollection;
use CommerceGuys\Addressing\Model\Subdivision;

/**
 * Class AdministrativeArea
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeArea extends Subdivision
{
    public function __construct(Subdivision $subdivision)
    {
        $this->copyPropertiesFromBaseClass($subdivision);
    }

    protected function copyPropertiesFromBaseClass(Subdivision $subdivision)
    {
        foreach (get_object_vars($subdivision) as $key => $value) {
            $this->$key = $value;
        }
//        if ($subdivision->hasChildren()) {
//            /** @var LazySubdivisionCollection $children */
//            $children = $subdivision->getChildren();
//            $children->setRepository($this);
//            $this->setChildren($children);
//        }
    }
}