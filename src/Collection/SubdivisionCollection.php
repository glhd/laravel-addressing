<?php

namespace Galahad\LaravelAddressing\Collection;

use CommerceGuys\Addressing\Subdivision\Subdivision as BaseSubdivision;
use Galahad\LaravelAddressing\Entity\Subdivision;
use Illuminate\Support\Collection;

class SubdivisionCollection extends Collection
{
	public function __construct($items = [])
	{
		parent::__construct($items);
		
		foreach ($this->items as $key => $item) {
			if ($item instanceof BaseSubdivision) {
				$this->items[$key] = new Subdivision($item);
			}
		}
	}
	// /**
	//  * @var array|mixed
	//  */
	// protected $countryCode;
	//
	// /**
	//  * @var string
	//  */
	// protected $parentId;
	//
	// /**
	//  * @var string|null
	//  */
	// protected $locale = null;
	//
	// /**
	//  * @var SubdivisionRepository
	//  */
	// protected $subdivisionRepository;
	//
	// /**
	//  * @return array|mixed
	//  */
	// public function getCountryCode()
	// {
	// 	return $this->countryCode;
	// }
	//
	// /**
	//  * @param array|mixed $countryCode
	//  */
	// public function setCountryCode($countryCode)
	// {
	// 	$this->countryCode = $countryCode;
	// }
	//
	// /**
	//  * @return mixed
	//  */
	// public function getParentId()
	// {
	// 	return $this->parentId;
	// }
	//
	// /**
	//  * @param mixed $parentId
	//  */
	// public function setParentId($parentId)
	// {
	// 	$this->parentId = $parentId;
	// }
	//
	// /**
	//  * @return null
	//  */
	// public function getLocale()
	// {
	// 	return $this->locale;
	// }
	//
	// /**
	//  * @param null $locale
	//  */
	// public function setLocale($locale)
	// {
	// 	$this->locale = $locale;
	// }
	//
	// /**
	//  * @return mixed
	//  */
	// public function getSubdivisionRepository()
	// {
	// 	return $this->subdivisionRepository;
	// }
	//
	// /**
	//  * @param mixed $subdivisionRepository
	//  */
	// public function setSubdivisionRepository(SubdivisionRepository $subdivisionRepository)
	// {
	// 	$this->subdivisionRepository = $subdivisionRepository;
	// }
}
