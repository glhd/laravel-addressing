<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Country\CountryRepositoryInterface;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Entity\Country;

class LaravelAddressing
{
	/**
	 * @var string
	 */
	protected $locale;
	
	/**
	 * @var string
	 */
	protected $fallback_locale;
	
	/**
	 * @var \CommerceGuys\Addressing\Country\CountryRepositoryInterface
	 */
	protected $country_repository;
	
	/**
	 * @var \CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface
	 */
	protected $subdivision_repository;
	
	/**
	 * @var \CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface
	 */
	protected $address_format_repository;
	
	/**
	 * Constructor method
	 *
	 * @param \CommerceGuys\Addressing\Country\CountryRepositoryInterface $country_repository
	 * @param \CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface $subdivision_repository
	 * @param \CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface $address_format_repository
	 * @param string $locale
	 * @param string $fallback_locale
	 */
	public function __construct(CountryRepositoryInterface $country_repository, SubdivisionRepositoryInterface $subdivision_repository, AddressFormatRepositoryInterface $address_format_repository, $locale = 'en', $fallback_locale = 'en')
	{
		$this->country_repository = $country_repository;
		$this->subdivision_repository = $subdivision_repository;
		$this->address_format_repository = $address_format_repository;
		
		$this->locale = $locale;
		$this->fallback_locale = $fallback_locale;
	}
	
	/**
	 * Get a country by code
	 *
	 * @param string $iso_alpha2_code
	 * @param string|null $locale
	 * @return \Galahad\LaravelAddressing\Entity\Country
	 */
	public function country($iso_alpha2_code, $locale = null) : Country
	{
		$base_country = $this->country_repository->get($iso_alpha2_code, $locale ?? $this->locale);
		
		return new Country($base_country, $this->subdivision_repository);
	}
	//
	// /**
	//  * Get a Country instance by name
	//  *
	//  * @param string $countryName
	//  * @return Country
	//  * @throws UnknownCountryException
	//  */
	// public function countryByName($countryName)
	// {
	// 	$key = strtolower($countryName);
	// 	$inverseCountryList = array_change_key_case(array_flip($this->getCountryList()), CASE_LOWER);
	//
	// 	if (isset($inverseCountryList[$key])) {
	// 		$countryCode = $inverseCountryList[$key];
	//
	// 		return $this->country($countryCode);
	// 	}
	//
	// 	throw new UnknownCountryException();
	// }
	//
	// /**
	//  * Find a country by code or name
	//  *
	//  * @param string $codeOrName
	//  * @return CountryInterface|Country
	//  * @throws UnknownCountryException
	//  */
	// public function findCountry($codeOrName)
	// {
	// 	try {
	// 		return $this->country($codeOrName);
	// 	} catch (UnknownCountryException $exception) {
	// 		return $this->countryByName($codeOrName);
	// 	}
	// }
	//
	// /**
	//  * Return a country collection with all countries
	//  *
	//  * @return Collection\CountryCollection
	//  */
	// public function countries()
	// {
	// 	return $this->getCountryRepository()->getAll($this->locale, $this->fallback_locale);
	// }
	//
	// /**
	//  * Get a list of all countries as a array list
	//  *
	//  * @return array
	//  */
	// public function countriesList()
	// {
	// 	return $this->getCountryList();
	// }
	//
	// /**
	//  * @return string
	//  */
	// public function getLocale()
	// {
	// 	return $this->locale;
	// }
	//
	// /**
	//  * @param string $locale
	//  */
	// public function setLocale($locale)
	// {
	// 	$this->locale = $locale;
	// }
	//
	// /**
	//  * @return string
	//  */
	// public function getFallbackLocale()
	// {
	// 	return $this->fallback_locale;
	// }
	//
	// /**
	//  * @param string $locale
	//  */
	// public function setFallbackLocale($locale)
	// {
	// 	$this->fallback_locale = $locale;
	// }
	//
	// /**
	//  * @return CountryRepository
	//  */
	// public function getCountryRepository()
	// {
	// 	if (!$this->country_repository) {
	// 		$this->country_repository = new CountryRepository($this);
	// 	}
	//
	// 	return $this->country_repository;
	// }
	//
	// /**
	//  * @return AdministrativeAreaRepository
	//  */
	// public function getAdministrativeAreaRepository()
	// {
	// 	if (!$this->administrative_area_repository) {
	// 		$this->administrative_area_repository = new AdministrativeAreaRepository($this);
	// 	}
	//
	// 	return $this->administrative_area_repository;
	// }
	//
	// /**
	//  * @return \Galahad\LaravelAddressing\Repository\AddressFormatRepository
	//  */
	// public function getAddressFormatRepository()
	// {
	// 	if (!$this->address_format_repository) {
	// 		$this->address_format_repository = new AddressFormatRepository($this);
	// 	}
	//
	// 	return $this->address_format_repository;
	// }
	//
	// /**
	//  * Get the country list if not loaded yet
	//  *
	//  * @return array
	//  */
	// protected function getCountryList()
	// {
	// 	if (!$this->country_list) {
	// 		$this->country_list = $this->getCountryRepository()->getList($this->locale, $this->fallback_locale);
	// 	}
	//
	// 	return $this->country_list;
	// }
}
