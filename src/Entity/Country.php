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
	protected $administrativeAreaList = [];
	
	/**
	 * @param LaravelAddressing $addressing
	 * @param BaseCountry $baseCountry
	 */
	public function __construct(LaravelAddressing $addressing, BaseCountry $baseCountry)
	{
		$this->addressing = $addressing;
		$this->copyPropertiesFromBaseCountry($baseCountry);
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
		$code = strtoupper($code);
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
			if (0 === strcasecmp($name, $administrativeAreaName)) {
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
		if ($administrativeArea = $this->administrativeArea($codeOrName)) {
			return $administrativeArea;
		}
		
		return $this->administrativeAreaByName($codeOrName);
	}
	
	/**
	 * Get all administrative areas as a array list
	 *
	 * @return array
	 */
	public function getAdministrativeAreasList()
	{
		if (!$this->administrativeAreaList) {
			$this->administrativeAreaList = $this->addressing->getAdministrativeAreaRepository()->getList(
				$this->getCountryCode(), 0, $this->getLocale()
			);
		}
		
		return $this->administrativeAreaList;
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
	
	/**
	 * @param BaseCountry $baseCountry
	 */
	protected function copyPropertiesFromBaseCountry(BaseCountry $baseCountry)
	{
		$vars = get_object_vars($baseCountry);
		foreach ($vars as $key => $value) {
			$this->$key = $value;
		}
	}
}
