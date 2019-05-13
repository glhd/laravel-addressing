<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Country\CountryRepositoryInterface;
use CommerceGuys\Addressing\Exception\UnknownCountryException;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Collection\CountryCollection;
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
	 * @var \Galahad\LaravelAddressing\Collection\CountryCollection
	 */
	protected $countries;
	
	/**
	 * @var bool
	 */
	protected $all_countries_loaded = false;
	
	/**
	 * Constructor
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
		
		$this->countries = new CountryCollection();
	}
	
	/**
	 * Get a country by 2-letter ISO code
	 *
	 * @param string $country_code
	 * @param string|null $locale
	 * @return \Galahad\LaravelAddressing\Entity\Country
	 */
	public function country($country_code, $locale = null) : ?Country
	{
		$country_code = strtoupper($country_code);
		
		if (!$this->countries->has($country_code)) {
			try {
				$this->countries->put($country_code, new Country(
					$this->country_repository->get($country_code, $locale ?? $this->locale),
					$this->subdivision_repository,
					$this->address_format_repository
				));
			} catch (UnknownCountryException $exception) {
				//
			}
		}
		
		return $this->countries->get($country_code, null);
	}
	
	/**
	 * Get all countries as a collection
	 *
	 * @param string|null $locale
	 * @return \Galahad\LaravelAddressing\Collection\CountryCollection
	 */
	public function countries($locale = null) : CountryCollection
	{
		if (!$this->all_countries_loaded) {
			$all_countries = $this->country_repository->getAll($locale ?? $this->locale);
			foreach ($all_countries as $country_code => $base_country) {
				$this->countries->put($country_code, new Country(
					$base_country,
					$this->subdivision_repository,
					$this->address_format_repository
				));
			}
			
			$this->all_countries_loaded = true;
		}
		
		return $this->countries;
	}
	
	/**
	 * Load a country by its full name
	 *
	 * @param string $name
	 * @return \Galahad\LaravelAddressing\Entity\Country|null
	 */
	public function countryByName($name) : ?Country
	{
		return $this->countries()
			->first(static function(Country $country) use ($name) {
				return 0 === strcasecmp($country->getName(), $name);
			});
	}
	
	/**
	 * Find a country, either by code or by name
	 *
	 * @param string $input
	 * @return \Galahad\LaravelAddressing\Entity\Country|null
	 */
	public function findCountry($input) : ?Country
	{
		return $this->country($input) ?? $this->countryByName($input);
	}
}
