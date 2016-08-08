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
     * @var array
     */
    protected $administrativeAreasList = [];

    /**
     * The constructor method
     *
     * @param LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }
	
	/**
	 * Maybe replace __construct() with this?
	 */
    public function __construct2(LaravelAddressing $addressing, BaseCountry $extend)
    {
    	$vars = get_object_vars($extend);
	    foreach ($vars as $key => $value) {
	    	$this->$key = $value;
	    }
    }

    /**
     * Get all country's administrative areas
     *
     * @return AdministrativeAreaCollection
     */
    public function administrativeAreas()
    {
        return $this->addressing->getAdministrativeAreaRepository()->getAll(
            $this->getCountryCode(),
            0,
            $this->getLocale()
        );
    }

    /**
     * Get an administrative area by code
     *
     * @param $code
     * @return AdministrativeArea
     */
    public function administrativeArea($code)
    {
        if (strpos($code, '-') === false) {
            $code = $this->getCountryCode().'-'.$code;
        }

        return $this->addressing->getAdministrativeAreaRepository()->get($code);
    }

    /**
     * Get an administrative area by name
     *
     * @param string $administrativeAreaName
     * @return AdministrativeArea
     */
    public function administrativeAreaByName($administrativeAreaName)
    {
        foreach ($this->getAdministrativeAreasList() as $code => $name) {
            if ($name == $administrativeAreaName) {
                return $this->administrativeArea($code);
            }
        }
    }

    /**
     * Find an administrative area by code or name
     *
     * @param string $codeOrName
     * @return AdministrativeArea
     */
    public function findAdministrativeArea($codeOrName)
    {
        $administrativeArea = $this->administrativeArea($codeOrName);
        if (! $administrativeArea instanceof AdministrativeArea) {
            return $this->administrativeAreaByName($codeOrName);
        }

        return $administrativeArea;
    }

    /**
     * Get all administrative areas as a array list
     *
     * @return array
     */
    public function getAdministrativeAreasList()
    {
        if (!$this->administrativeAreasList) {
            $this->administrativeAreasList = $this->addressing->getAdministrativeAreaRepository()->getList(
                $this->getCountryCode(), 0, $this->getLocale()
            );
        }

        return $this->administrativeAreasList;
    }

    /**
     * Get the locale according the LaravelAddressing class
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->addressing->getLocale();
    }
}