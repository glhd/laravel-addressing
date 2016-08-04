<?php

namespace Galahad\LaravelAddressing\Entity;

use ArrayObject;
use CommerceGuys\Addressing\Model\Subdivision;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Collection\LocalityCollection;

/**
 * Class AdministrativeArea
 *
 * @package Galahad\LaravelAddressing
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeArea extends Entity
{
	/**
	 * @var Country|null
	 */
	protected $country = null;

	/**
	 * @var null|string
	 */
	protected $code = null;

	/**
	 * @var null|string
	 */
	protected $name = null;

    /**
     * @var string|null
     */
    protected $postalCodePattern;

	/**
	 * @var string
	 */
	protected $locale = 'en';

	/**
	 * @var null|LocalityCollection
	 */
	protected $localities = null;

	/**
	 * @var SubdivisionRepository|null
	 */
	protected $subdivisionRepository;

	/**
	 * @var Subdivision
	 */
	protected $subdivision;

	/**
	 * Construct method
	 *
	 * @param Country|string $country
	 */
	public function __construct($country)
	{
		if ($country instanceof Country) {
			$this->country = $country;
		} elseif (is_string($country)) {
			$object = new Country;
			$this->country = $object->getByCode($country);
		}

		$this->subdivisionRepository = $this->getCountry()->getSubdivisionRepository();
	}

	/**
	 * Get all administrative areas from a given country
	 *
	 * @return ArrayObject
	 */
	public function getAll()
	{
		$country = $this->getCountry();
		$repo = $country->getSubdivisionRepository();
		$list = new AdministrativeAreaCollection();
        $locale = $this->country->getLocale();
		/** @var Subdivision $subdivision */
		foreach ($repo->getAll($country->getCode(), 0, $locale) as $subdivision) {
			$admArea = new static($country);
			$admArea->setCode($subdivision->getCode());
			$admArea->setName($subdivision->getName());
			$admArea->setLocale($country->getLocale());
            $admArea->setPostalCodePattern($subdivision->getPostalCodePattern());
			$admArea->setSubdivision($subdivision);
			$list->insert($admArea);
		}

		return $list;
	}

	/**
	 * Get an administrative area by field and value
	 *
	 * @param $fieldName
	 * @param $fieldValue
	 * @return AdministrativeArea
	 */
	protected function getByField($fieldName, $fieldValue)
	{
		$fieldValue = strtolower($fieldValue);
		$list = $this->getAll();
		/** @var AdministrativeArea $admArea */
		foreach ($list as $admArea) {
			$method = 'get'.ucfirst($fieldName);
			if (strtolower($admArea->$method()) == $fieldValue) {
				return $admArea;
			}
		}
	}

	/**
	 * Get an administrative area by code
	 *
	 * @param $code
	 * @return AdministrativeArea
	 */
	public function getByCode($code)
	{
		return $this->getByField('code', $code);
	}

	/**
	 * Shortcut for getByCode()
	 *
	 * @param $code
	 * @return AdministrativeArea
	 */
	public function code($code)
	{
		return $this->getByCode($code);
	}

	/**
	 * Get an administrative area by name
	 *
	 * @param $name
	 * @return AdministrativeArea
	 */
	public function getByName($name)
	{
		return $this->getByField('name', $name);
	}

	/**
	 * Shortcut for getByName()
	 *
	 * @param $name
	 * @return AdministrativeArea
	 */
	public function name($name)
	{
		return $this->getByName($name);
	}

    /**
     * Get an administrative area by code or by name
     *
     * @param string $value
     * @return AdministrativeArea|null
     */
    public function getByCodeOrName($value)
	{
        $result = $this->getByCode($value);
        if (! $result instanceof AdministrativeArea) {
            $result = $this->getByName($value);
            if (! $result instanceof AdministrativeArea) {
                return null;
            }
        }

        return $result;
	}

	/**
	 * Get the country instance
	 *
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Set the country instance
	 *
	 * @param Country|null $country
	 */
	public function setCountry(Country $country)
	{
		$this->country = $country;
	}

	/**
	 * Get the administrative area code
	 *
	 * @return null
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set the administrative area code
	 *
	 * @param null $code
	 */
	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * Get the administrative area name
	 *
	 * @return null
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the administrative area name
	 *
	 * @param null $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * @param string $locale
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;
	}

	/**
	 * @return Subdivision
	 */
	public function getSubdivision()
	{
		return $this->subdivision;
	}

	/**
	 * @param Subdivision $subdivision
	 */
	public function setSubdivision(Subdivision $subdivision)
	{
		$this->subdivision = $subdivision;
	}

	/**
	 * Get the administrative area localities
	 *
	 * @return \Galahad\LaravelAddressing\Collection\LocalityCollection
	 */
	public function getLocalities()
	{
		if ($this->localities instanceof LocalityCollection) {
			return $this->localities;
		}

		$locality = new Locality($this);
		$this->setLocalities($locality->getAll());

		return $this->localities;
	}

	/**
	 * Shortcut for the getLocalities() method
	 *
	 * @return LocalityCollection
	 */
	public function cities()
	{
		return $this->getLocalities();
	}

	/**
	 * Shortcut to get a Locality from an AdministrativeArea object
	 *
	 * @param $name
	 * @return Locality
	 */
	public function city($name)
	{
		return $this->getLocalities()->getByName($name);
	}

	/**
	 * Shortcut to get a locality from an administrative area
	 *
	 * @param $name
	 * @return Locality
	 */
	public function locality($name)
	{
		return $this->getLocalities()->getByName($name);
	}

	/**
	 * Set the administrative area localities
	 *
	 * @param LocalityCollection $localities
	 */
	protected function setLocalities(LocalityCollection $localities)
	{
		$this->localities = $localities;
	}

	/**
	 * @return SubdivisionRepository|null
	 */
	public function getSubdivisionRepository()
	{
		return $this->subdivisionRepository;
	}

    /**
     * Get the postal code pattern
     *
     * @return null|string
     */
    public function getPostalCodePattern()
    {
        return $this->postalCodePattern;
    }

    /**
     * Set the postal code pattern
     *
     * @param null|string $postalCodePattern
     */
    public function setPostalCodePattern($postalCodePattern)
    {
        $this->postalCodePattern = $postalCodePattern;
    }
}