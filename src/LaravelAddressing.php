<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\Repository\SubdivisionRepository;

/**
 * Class LaravelAddressing
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LaravelAddressing
{
    const ARRAY_LIST = 1;

    /**
     * @var SubdivisionRepository
     */
    protected $subdivisionRepository;

    /**
     * @var Country
     */
    protected $country;

    /**
     * The construct method
     */
    public function __construct()
    {
        $this->subdivisionRepository = new SubdivisionRepository();
        $this->country = new Country();
    }

    /**
     * Get the country by code
     *
     * @param $code
     * @return Country|null
     */
    public function country($code)
    {
        return $this->country->getByCode($code);
    }

    /**
     * Get the countries list
     *
     * Example:
     * $addressing = new LaravelAddressing;
     * return $addressing->countries(LaravelAddressing::ARRAY_LIST);
     *
     * @param int $asArrayList
     * @return CountryCollection|array
     */
    public function countries($asArrayList = 0)
    {
        if ($asArrayList === static::ARRAY_LIST) {
            return $this->country->getAll()->toList();
        }

        return $this->country->getAll();
    }

    public function getAdministrativeAreas($countryCode)
    {
        $repo = $this->getSubdivisionRepository();

        return $repo->getAll($countryCode);
    }

    protected function getSubdivisionRepository()
    {
        if (!isset($this->subdivisionRepository)) {
            $this->subdivisionRepository = new SubdivisionRepository();
        }

        return $this->subdivisionRepository;
    }

    protected function getAddressFormatRepository()
    {
        // TODO
    }
}