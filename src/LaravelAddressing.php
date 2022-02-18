<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Country\CountryRepositoryInterface;
use CommerceGuys\Addressing\Exception\UnknownCountryException;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Exceptions\CountryNotFoundException;
use Illuminate\Support\Traits\Macroable;

class LaravelAddressing
{
	use Macroable;
	
	protected string $locale;
	
	protected string $fallback_locale;
	
	protected CountryRepositoryInterface $country_repository;
	
	protected SubdivisionRepositoryInterface $subdivision_repository;
	
	protected AddressFormatRepositoryInterface $address_format_repository;
	
	protected CountryCollection $countries;
	
	protected bool $all_countries_loaded = false;
	
	public function __construct(
		CountryRepositoryInterface $country_repository,
		SubdivisionRepositoryInterface $subdivision_repository,
		AddressFormatRepositoryInterface $address_format_repository,
		string $locale = 'en',
		string $fallback_locale = 'en'
	) {
		$this->country_repository = $country_repository;
		$this->subdivision_repository = $subdivision_repository;
		$this->address_format_repository = $address_format_repository;

		$this->locale = $locale;
		$this->fallback_locale = $fallback_locale;

		$this->countries = new CountryCollection();
	}

	/**
	 * Get a country by 2-letter ISO code.
	 *
	 * @todo The locale parameter isn't always applied
	 *
	 * @param string $country_code
	 * @param string|null $locale
	 * @return \Galahad\LaravelAddressing\Entity\Country
	 */
	public function country(string $country_code, ?string $locale = null): ?Country
	{
		$country_code = strtoupper($country_code);

		if (! $this->countries->has($country_code)) {
			try {
				$this->countries->put($country_code, new Country(
					$this->country_repository->get($country_code, $locale ?? $this->locale),
					$this->subdivision_repository,
					$this->address_format_repository
				));
			} catch (UnknownCountryException $exception) {
			}
		}

		return $this->countries->get($country_code, null);
	}
	
	public function countryOrFail(string $country_code, ?string $locale = null): Country
	{
		if ($country = $this->country($country_code, $locale)) {
			return $country;
		}
		
		throw new CountryNotFoundException($country_code);
	}

	/**
	 * Get all countries as a collection.
	 *
	 * @todo The locale parameter is only applied the first time
	 *
	 * @param string|null $locale
	 * @return \Galahad\LaravelAddressing\Collection\CountryCollection
	 */
	public function countries(?string $locale = null): CountryCollection
	{
		if (! $this->all_countries_loaded) {
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
	 * Load a country by its full name.
	 *
	 * @param string $name
	 * @return \Galahad\LaravelAddressing\Entity\Country|null
	 */
	public function countryByName(string $name): ?Country
	{
		return $this->countries()
			->first(fn(Country $country) => 0 === strcasecmp($country->getName(), $name));
	}

	/**
	 * Find a country, either by code or by name.
	 *
	 * @param string $input
	 * @return \Galahad\LaravelAddressing\Entity\Country|null
	 */
	public function findCountry(string $input): ?Country
	{
		return $this->country($input) ?? $this->countryByName($input);
	}
}
