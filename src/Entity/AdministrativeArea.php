<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Subdivision\Subdivision as BaseSubdivision;

class AdministrativeArea extends Subdivision
{
	public function __construct(Country $country, BaseSubdivision $subdivision)
	{
		parent::__construct($country, $subdivision);
	}

	public function getParent(): ?Subdivision
	{
		return null;
	}

	public function is(Subdivision $subdivision = null): bool
	{
		if (!($subdivision instanceof self)) {
			return false;
		}

		return $this->getCountry()->is($subdivision->getCountry())
            && $this->getCode() === $subdivision->getCode();
	}
}
