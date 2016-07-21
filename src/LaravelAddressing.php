<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;

class LaravelAddressing
{
	/** @var SubdivisionRepository */
	protected $subdivisionRepository;
	
	public function getCountry($code)
	{
		// Return a country object
	}
	
	public function getCountries()
	{
		// Return 2-digit => name
	}
	
	public function getAdministrativeAreas($countryCode)
	{
		$repo = $this->getSubdivisionRepository();
		return $repo->getAll($countryCode);
	}
	
	protected function getSubdivisionRepository()
	{
		if (!isset($this->subdivisionRepository)) {
			$this->subdivisionRepository = new SubdivisionRepository();
		}
		
		return $this->subdivisionRepository;
	}
	
	protected function getAddressFormatRepository()
	{
		// TODO
	}
}