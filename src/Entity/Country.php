<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Intl\Country\Country as BaseCountry;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\LaravelAddressing;

/**
 * Class Country
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Country extends BaseCountry
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * The constructor method
     */
    public function __construct()
    {
        $this->addressing = LaravelAddressing::getInstance();
    }

    /**
     * Get all country's administrative areas
     *
     * @return AdministrativeAreaCollection
     */
    public function administrativeAreas()
    {
        $administrativeAreaRepository = $this->addressing->getAdministrativeAreaRepository();
        $locale = $this->addressing->getLocale();

        return $administrativeAreaRepository->getAll($this->getCountryCode(), 0, $locale);
    }
}