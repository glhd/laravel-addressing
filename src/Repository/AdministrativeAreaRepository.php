<?php

namespace Galahad\LaravelAddressing\Repository;

use CommerceGuys\Addressing\Collection\LazySubdivisionCollection;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Entity\AdministrativeArea;

/**
 * Class AdministrativeAreaRepository
 *
 * @package Galahad\LaravelAddressing\Repository
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaRepository extends SubdivisionRepository
{
    /**
     * Create Subdivisions using the custom AdministrativeArea class
     *
     * @param int $id
     * @param array $definitions
     * @param string $locale
     * @return AdministrativeArea|null
     */
    protected function createSubdivisionFromDefinitions($id, array $definitions, $locale)
    {
        $subdivision = parent::createSubdivisionFromDefinitions($id, $definitions, $locale);
        if (!is_null($subdivision)) {
            $administrativeArea = new AdministrativeArea($subdivision);
            if (!empty($definition['has_children'])) {
                $children = new LazySubdivisionCollection($definition['country_code'], $id, $definition['locale']);
                $children->setRepository($this);
                $administrativeArea->setChildren($children);
            }

            return $administrativeArea;
        }

        return $subdivision;
    }

    /**
     * Get all administrative areas as a collection instance
     *
     * @param string $countryCode
     * @param null $parentId
     * @param null $locale
     * @return AdministrativeAreaCollection
     */
    public function getAll($countryCode, $parentId = null, $locale = null)
    {
        $subdivisions = parent::getAll($countryCode, $parentId, $locale);

        return new AdministrativeAreaCollection($subdivisions);
    }

    /**
     * Overriding method just for autocompletion purposes
     *
     * @param string $id
     * @param null $locale
     * @return AdministrativeArea
     */
    public function get($id, $locale = null)
    {
        return parent::get($id, $locale);
    }
}