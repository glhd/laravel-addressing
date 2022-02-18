<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\AddressFormat\AddressFormat;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Country\Country as BaseCountry;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Exceptions\AdministrativeAreaNotFoundException;

/**
 * @property-read $country_code
 * @property-read $name
 * @property-read $three_letter_code
 * @property-read $numeric_code
 * @property-read $currency_code
 * @property-read $timezones
 * @property-read $locale
 *
 * @mixin \CommerceGuys\Addressing\Country\Country
 */
class Country
{
	use DecoratesEntity;
	
	protected BaseCountry $country;
	
	protected SubdivisionRepositoryInterface $subdivision_repository;
	
	protected AddressFormatRepositoryInterface $address_format_repository;
	
	protected ?AdministrativeAreaCollection $administrative_areas = null;
	
	protected ?AddressFormat $address_format = null;
	
	public function __construct(
		BaseCountry $country,
		SubdivisionRepositoryInterface $subdivision_repository,
		AddressFormatRepositoryInterface $address_format_repository
	) {
		$this->country = $country;
		$this->subdivision_repository = $subdivision_repository;
		$this->address_format_repository = $address_format_repository;
	}
	
	public function addressFormat(): AddressFormat
	{
		if (null === $this->address_format) {
			$this->address_format = $this->address_format_repository->get($this->country->getCountryCode());
		}

		return $this->address_format;
	}

	public function getAdministrativeAreaLabel(): ?string
	{
		return $this->addressFormat()->getAdministrativeAreaType();
	}

	public function getLocalityLabel(): ?string
	{
		return $this->addressFormat()->getLocalityType();
	}

	public function administrativeAreas(): AdministrativeAreaCollection
	{
		if (null === $this->administrative_areas) {
			$this->administrative_areas = AdministrativeAreaCollection::make()->setCountry($this);

			$subdivisions = $this->subdivision_repository->getAll([$this->country->getCountryCode()]);
			foreach ($subdivisions as $code => $subdivision) {
				$this->administrative_areas->put($code, new AdministrativeArea($this, $subdivision));
			}
		}

		return $this->administrative_areas;
	}
	
	public function administrativeArea(string $code): ?AdministrativeArea
	{
		// First try on the assumption that it's a 2-letter upper case code.
		// If that doesn't work, do a case-insensitive lookup.
		
		return $this->administrativeAreas()->get(strtoupper($code))
			?? $this->administrativeAreas()->first(fn(AdministrativeArea $subdivision) => 0 === strcasecmp($subdivision->getCode(), $code));
	}
	
	public function administrativeAreaOrFail(string $code): AdministrativeArea
	{
		if ($administrative_area = $this->administrativeArea($code)) {
			return $administrative_area;
		}
		
		throw new AdministrativeAreaNotFoundException($this->getCountryCode(), $code);
	}
	
	public function administrativeAreaByName(string $name): ?AdministrativeArea
	{
		return $this->administrativeAreas()
			->first(fn(AdministrativeArea $subdivision) => 0 === strcasecmp($subdivision->getName(), $name));
	}

	/**
	 * Find an administrative area, either by code or by name.
	 *
	 * @param string $input
	 * @return \Galahad\LaravelAddressing\Entity\AdministrativeArea|null
	 */
	public function findAdministrativeArea(string $input): ?AdministrativeArea
	{
		return $this->administrativeArea($input) ?? $this->administrativeAreaByName($input);
	}

	public function is(self $country = null): bool
	{
		if (null === $country) {
			return false;
		}

		return $this->getCountryCode() === $country->getCountryCode();
	}
	
	protected function decoratedEntity()
	{
		return $this->country;
	}
}
