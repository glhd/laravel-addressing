<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use InvalidArgumentException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AdministrativeAreaValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidator
{
    /**
     * The validator messages
     *
     * @var array
     */
    protected $messages = [
        'administrative_area' => 'The :attribute has not a valid administrative area name.',
        'administrative_area_code' => 'The :attribute has not a valid administrative area code.',
        'administrative_area_name' => 'The :attribute has not a valid administrative area name.',
    ];

    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * @param LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing) {
        $this->addressing = $addressing;
    }

    /**
     * Validate an Administrative Area by its code and country
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validateAdministrativeAreaCode($attribute, $value, array $parameters, Validator $validator)
    {
        $this->validateParameterCount(1, $parameters, $attribute);
        $validator->setCustomMessages($this->messages);
        $country = $this->getCountryInstance($parameters, $validator);
        $admArea = $country->administrativeArea($value);

        return $admArea instanceof AdministrativeArea;
    }

    /**
     * Validate an Administrative Area by its name and country
     *
     * @param $attribute
     * @param $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validateAdministrativeAreaName($attribute, $value, array $parameters, Validator $validator)
    {
        $this->validateParameterCount(1, $parameters, $attribute);
        $validator->setCustomMessages($this->messages);
        $country = $this->getCountryInstance($parameters, $validator);
        $admArea = $country->administrativeAreaByName($value);

        return $admArea instanceof AdministrativeArea;
    }

    /**
     * Validate an administrative area trying first by code and after by name
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validateAdministrativeArea($attribute, $value, array $parameters, Validator $validator)
    {
        $validator->setCustomMessages($this->messages);
        $codeValidation = $this->validateAdministrativeAreaCode($attribute, $value, $parameters, $validator);
        if (! $codeValidation) {
            return $this->validateAdministrativeAreaName($attribute, $value, $parameters, $validator);
        }

        return true;
    }

    /**
     * Get the country instance according the parameters and values
     *
     * @param array $parameters
     * @param Validator $validator
     * @return Country|null
     */
    private function getCountryInstance(array $parameters, Validator $validator)
    {
        $countryCodeOrName = array_get($validator->getData(), $parameters[0]);

        return $this->addressing->findCountry($countryCodeOrName);
    }

    /**
     * @param $count
     * @param array $parameters
     * @param $rule
     */
    public function validateParameterCount($count, array $parameters, $rule)
    {
        if (count($parameters) !== $count) {
            throw new InvalidArgumentException("Validation rule $rule requires at least $count parameter.");
        }
    }

    /**
     * @return LaravelAddressing
     */
    public function getAddressing()
    {
        return $this->addressing;
    }

    /**
     * @param LaravelAddressing $addressing
     */
    public function setAddressing(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }
}