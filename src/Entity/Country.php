<?php

namespace Galahad\LaravelAddressing\Entity;

// use CommerceGuys\Addressing\Country\Country as BaseCountry;
// use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
// use Galahad\LaravelAddressing\LaravelAddressing;

// TODO: decide on ->getX() or just ->x()

use CommerceGuys\Addressing\AddressFormat\AddressFormat;
use CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface;
use CommerceGuys\Addressing\Country\Country as BaseCountry;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface;
use Galahad\LaravelAddressing\Collection\SubdivisionCollection;

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
	 * @var \CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface
	 */
	protected $address_format_repository;
	
	/**
	 * Country constructor.
	 *
	 * @param \CommerceGuys\Addressing\Country\Country $country
	 * @param \CommerceGuys\Addressing\Subdivision\SubdivisionRepositoryInterface $subdivision_repository
	 * @param \CommerceGuys\Addressing\AddressFormat\AddressFormatRepositoryInterface $address_format_repository
	 */
	public function __construct(BaseCountry $country, SubdivisionRepositoryInterface $subdivision_repository, AddressFormatRepositoryInterface $address_format_repository)
	{
		$this->country = $country;
		$this->subdivision_repository = $subdivision_repository;
		$this->address_format_repository = $address_format_repository;
	}
	
	public function addressFormat() : AddressFormat
	{
		return $this->address_format_repository->get($this->country->getCountryCode());
	}
	
	public function getAdministrativeAreaLabel() : ?string
	{
		return $this->addressFormat()->getAdministrativeAreaType();
	}
	
	public function getLocalityLabel() : string
	{
		return $this->addressFormat()->getLocalityType();
	}
	
	public function subdivisions() : SubdivisionCollection
	{
		return new SubdivisionCollection(
			$this->subdivision_repository->getAll([$this->country->getCountryCode()])
		);
	}
	
	/**
	 * Get an array of subdivisions in code => Entity form
	 *
	 * @return array
	 */
	public function subdivisionList() : array
	{
		return $this->subdivisions()
			->mapWithKeys(static function(Subdivision $subdivision) {
				return [$subdivision->getCode() => $subdivision];
			})
			->toArray();
	}
	
	/**
	 * @param string $code
	 * @return \Galahad\LaravelAddressing\Entity\Subdivision|null
	 */
	public function subdivision($code) : ?Subdivision
	{
		if ($base = $this->subdivision_repository->get($code, [$this->country->getCountryCode()])) {
			return new Subdivision($base);
		}
		
		return null;
	}
	
	/**
	 * @param string $name
	 * @return \Galahad\LaravelAddressing\Entity\Subdivision|null
	 */
	public function subdivisionByName($name) : ?Subdivision
	{
		return $this->subdivisions()
			->first(static function(Subdivision $subdivision) use ($name) {
				return 0 === strcasecmp($subdivision->getName(), $name);
			});
	}
	
	public function is(Country $country = null) : bool
	{
		if (null === $country) {
			return false;
		}
		
		return $this->getCountryCode() === $country->getCountryCode();
	}
	
	public function getCountryCode() : string
	{
		return $this->country->getCountryCode();
	}
	
	public function getName() : string
	{
		return $this->country->getName();
	}
	
	public function getThreeLetterCode() : string
	{
		return $this->country->getThreeLetterCode();
	}
	
	public function getNumericCode() : int
	{
		return (int) $this->country->getNumericCode();
	}
	
	public function getCurrencyCode() : string
	{
		return $this->country->getCurrencyCode();
	}
	
	/**
	 * @return string[]
	 */
	public function getTimezones() : array
	{
		return $this->country->getTimezones();
	}
	
	public function getLocale() : string
	{
		return $this->country->getLocale();
	}
	
	public function __call($name, $arguments)
	{
		return $this->country->$name(...$arguments);
	}
}
