<?php
//
// namespace Galahad\LaravelAddressing\Repository;
//
// use CommerceGuys\Intl\Country\CountryInterface;
// use CommerceGuys\Intl\Country\CountryRepository as BaseCountryRepository;
// use Galahad\LaravelAddressing\Collection\CountryCollection;
// use Galahad\LaravelAddressing\Entity\Country;
// use Galahad\LaravelAddressing\LaravelAddressing;
//
// /**
//  * Class CountryRepository
//  *
//  * @package Galahad\LaravelAddressing\Repository
//  * @author Junior Grossi <juniorgro@gmail.com>
//  */
// class CountryRepository extends BaseCountryRepository
// {
// 	/**
// 	 * @var LaravelAddressing
// 	 */
// 	protected $addressing;
//
// 	/**
// 	 * @param LaravelAddressing $addressing
// 	 */
// 	public function __construct(LaravelAddressing $addressing)
// 	{
// 		$this->addressing = $addressing;
// 		parent::__construct();
// 	}
//
// 	/**
// 	 * Get a country by code
// 	 *
// 	 * @param string $countryCode
// 	 * @param null $locale
// 	 * @param null $fallbackLocale
// 	 * @return CountryInterface|Country
// 	 */
// 	public function get($countryCode, $locale = null, $fallbackLocale = null)
// 	{
// 		return parent::get(strtoupper($countryCode), $locale ?: $this->addressing->getLocale(),
// 			$fallbackLocale ?: $this->addressing->getFallbackLocale());
// 	}
//
// 	/**
// 	 * Get country list, keyed by code
// 	 *
// 	 * @param null $locale
// 	 * @param null $fallbackLocale
// 	 * @return array
// 	 */
// 	public function getList($locale = null, $fallbackLocale = null)
// 	{
// 		return parent::getList($locale ?: $this->addressing->getLocale(),
// 			$fallbackLocale ?: $this->addressing->getFallbackLocale());
// 	}
//
// 	/**
// 	 * Returns a CountryCollection with Country instances
// 	 *
// 	 * @param null $locale
// 	 * @param null $fallbackLocale
// 	 * @return CountryCollection
// 	 */
// 	public function getAll($locale = null, $fallbackLocale = null)
// 	{
// 		$countries = parent::getAll($locale, $fallbackLocale);
//
// 		return new CountryCollection($countries);
// 	}
//
// 	/**
// 	 * Get the main LaravelAddressing container
// 	 *
// 	 * @return LaravelAddressing
// 	 */
// 	public function getAddressing()
// 	{
// 		return $this->addressing;
// 	}
//
// 	/**
// 	 * @param LaravelAddressing $addressing
// 	 */
// 	public function setAddressing(LaravelAddressing $addressing)
// 	{
// 		$this->addressing = $addressing;
// 	}
//
// 	/**
// 	 * Create Country class for LaravelAddressing package
// 	 *
// 	 * @param string $countryCode
// 	 * @param array $definition
// 	 * @param string $locale
// 	 * @return Country
// 	 */
// 	protected function createCountryFromDefinition($countryCode, array $definition, $locale)
// 	{
// 		$parentCountry = parent::createCountryFromDefinition($countryCode, $definition, $locale);
//
// 		return new Country($this->getAddressing(), $parentCountry);
// 	}
// }
