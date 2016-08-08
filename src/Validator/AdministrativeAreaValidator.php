<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class AdministrativeAreaValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidator extends Validator
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
     * @param TranslatorInterface $translator
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function __construct(
        TranslatorInterface $translator,
        array $data = [],
        array $rules = [],
        array $messages = [],
        array $customAttributes = []
    ) {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
        $this->setCustomMessages($this->messages);
    }

    /**
     * Validate an Administrative Area by its code and country
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    protected function validateAdministrativeAreaCode($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'administrative_area_code');
        $country = $this->getCountryInstance($parameters);
        $admArea = $country->administrativeArea($value);

        return $admArea instanceof AdministrativeArea;
    }

    /**
     * Validate an Administrative Area by its name and country
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    protected function validateAdministrativeAreaName($attribute, $value, $parameters)
    {
        $this->requireParameterCount(1, $parameters, 'administrative_area_name');
        $country = $this->getCountryInstance($parameters);
        $admArea = $country->administrativeAreaByName($value);

        return $admArea instanceof AdministrativeArea;
    }

    /**
     * Validate an administrative area trying first by code and after by name
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function validateAdministrativeArea($attribute, $value, $parameters)
    {
        $codeValidation = $this->validateAdministrativeAreaCode($attribute, $value, $parameters);
        if (! $codeValidation) {
            return $this->validateAdministrativeAreaName($attribute, $value, $parameters);
        }

        return true;
    }

    /**
     * Get the country instance according the parameters and values
     *
     * @param array $parameters
     * @return Country|null
     */
    private function getCountryInstance(array $parameters)
    {
        $countryCodeOrName = $this->getValue($parameters[0]);

        return $this->addressing->findCountry($countryCodeOrName);
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