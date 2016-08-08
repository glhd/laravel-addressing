<?php

namespace Galahad\LaravelAddressing\Repository;

use Closure;
use CommerceGuys\Addressing\Collection\LazySubdivisionCollection;
use CommerceGuys\Addressing\Enum\PatternType;
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
        if (!isset($definitions['subdivisions'][$id])) {
            // No matching definition found.
            return null;
        }

        $definition = $this->translateDefinition($definitions['subdivisions'][$id], $locale);
        // Add common keys from the root level.
        $definition['country_code'] = $definitions['country_code'];
        $definition['parent_id'] = $definitions['parent_id'];
        $definition['locale'] = $definitions['locale'];
        // Provide defaults.
        if (!isset($definition['code'])) {
            $definition['code'] = $definition['name'];
        }
        // Load the parent, if known.
        $definition['parent'] = null;
        if (isset($definition['parent_id'])) {
            $parentId = $definition['parent_id'];
            if (!isset($this->parents[$parentId])) {
                $this->parents[$parentId] = $this->get($definition['parent_id']);
            }
            $definition['parent'] = $this->parents[$parentId];
        }

        $subdivision = new AdministrativeArea();
        // Bind the closure to the Subdivision object, giving it access to its
        // protected properties. Faster than both setters and reflection.
        $setValues = Closure::bind(function ($id, $definition) {
            $this->parent = $definition['parent'];
            $this->countryCode = $definition['country_code'];
            $this->id = $id;
            $this->code = $definition['code'];
            $this->name = $definition['name'];
            $this->locale = $definition['locale'];
            if (isset($definition['postal_code_pattern'])) {
                $this->postalCodePattern = $definition['postal_code_pattern'];
                if (isset($definition['postal_code_pattern_type'])) {
                    $this->postalCodePatternType = $definition['postal_code_pattern_type'];
                } else {
                    $this->postalCodePatternType = PatternType::getDefault();
                }
            }
        }, $subdivision, '\Galahad\LaravelAddressing\Entity\AdministrativeArea');
        $setValues($id, $definition);

        if (!empty($definition['has_children'])) {
            $children = new LazySubdivisionCollection($definition['country_code'], $id, $definition['locale']);
            $children->setRepository($this);
            $subdivision->setChildren($children);
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
    	// TODO Defering the parent here means that we don't have to keep up with changes as much
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