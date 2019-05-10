<?php

namespace Galahad\LaravelAddressing\Entity;

// use CommerceGuys\Addressing\Country\Country as BaseCountry;
// use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
// use Galahad\LaravelAddressing\LaravelAddressing;

use CommerceGuys\Addressing\Country\Country as BaseCountry;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;

/**
 * @method string getCountryCode()
 * @method string getName()
 * @method string getThreeLetterCode()
 * @method string getNumericCode()
 * @method string getCurrencyCode()
 * @method string getTimezones()
 * @method string getLocale()
 */
class Country
{
	/**
	 * @var \CommerceGuys\Addressing\Country\Country
	 */
	protected $country;
	
	/**
	 * @var \CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface
	 */
	protected $subdivision_repository;
	
	/**
	 * Country constructor.
	 *
	 * @param \CommerceGuys\Addressing\Country\Country $country
	 * @param \CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface $subdivision_repository
	 */
	public function __construct(BaseCountry $country, SubdivisionRepositoryInterface $subdivision_repository)
	{
		$this->country = $country;
		$this->subdivision_repository = $subdivision_repository;
	}
	
	
	public function administrativeAreas() : AdministrativeAreaCollection
	{
		return new AdministrativeAreaCollection(
			$this->subdivision_repository->getAll([$this->country->getCountryCode()])
		);
	}
	
	public function __call($name, $arguments)
	{
		return $this->country->$name(...$arguments);
	}
	
	// /**
	//  * @var LaravelAddressing
	//  */
	// protected $addressing;
	//
	// /**
	//  * @var array
	//  */
	// protected $administrativeAreasList = [];
	//
	// /**
	//  * @param LaravelAddressing $addressing
	//  * @param BaseCountry $baseCountry
	//  */
	// public function __construct(LaravelAddressing $addressing, BaseCountry $baseCountry)
	// {
	// 	$this->addressing = $addressing;
	// 	$this->copyPropertiesFromBaseCountry($baseCountry);
	// }
	//
	
	//
	// /**
	//  * Get an administrative area by code
	//  *
	//  * @param $code
	//  * @return AdministrativeArea
	//  */
	// public function administrativeArea($code)
	// {
	// 	$code = strtoupper($code);
	// 	if (strpos($code, '-') === false) {
	// 		$code = $this->getCountryCode().'-'.$code;
	// 	}
	//
	// 	return $this->addressing->getAdministrativeAreaRepository()->get($code);
	// }
	//
	// /**
	//  * Get an administrative area by name
	//  *
	//  * @param string $administrativeAreaName
	//  * @return AdministrativeArea
	//  */
	// public function administrativeAreaByName($administrativeAreaName)
	// {
	// 	foreach ($this->getAdministrativeAreasList() as $code => $name) {
	// 		if (0 === strcasecmp($name, $administrativeAreaName)) {
	// 			return $this->administrativeArea($code);
	// 		}
	// 	}
	// }
	//
	// /**
	//  * Find an administrative area by code or name
	//  *
	//  * @param string $codeOrName
	//  * @return AdministrativeArea
	//  */
	// public function findAdministrativeArea($codeOrName)
	// {
	// 	if ($administrativeArea = $this->administrativeArea($codeOrName)) {
	// 		return $administrativeArea;
	// 	}
	//
	// 	return $this->administrativeAreaByName($codeOrName);
	// }
	//
	// /**
	//  * Get all administrative areas as a array list
	//  *
	//  * @return array
	//  */
	// public function getAdministrativeAreasList()
	// {
	// 	if (!$this->administrativeAreasList) {
	// 		$this->administrativeAreasList = $this->addressing->getAdministrativeAreaRepository()->getList($this->getCountryCode(),
	// 			0, $this->getLocale());
	// 	}
	//
	// 	return $this->administrativeAreasList;
	// }
	//
	// /**
	//  * Get the locale according the LaravelAddressing class
	//  *
	//  * @return string
	//  */
	// public function getLocale()
	// {
	// 	return $this->addressing->getLocale();
	// }
	//
	// /**
	//  * @return null|string
	//  */
	// public function getPostalCodePattern()
	// {
	// 	return $this->addressing->getAddressFormatRepository()->get($this->getCountryCode())->getPostalCodePattern();
	// }
	//
	// /**
	//  * @param BaseCountry $baseCountry
	//  */
	// protected function copyPropertiesFromBaseCountry(BaseCountry $baseCountry)
	// {
	// 	$vars = get_object_vars($baseCountry);
	// 	foreach ($vars as $key => $value) {
	// 		$this->$key = $value;
	// 	}
	// }
}
