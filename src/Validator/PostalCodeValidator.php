<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class PostalCodeValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidator extends Validator
{
    /**
     * @var array
     */
    protected $messages = [
        'postal_code' => 'The :attribute seems do be a not valid postal code',
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
     * Validate a postal code using country and administrative area fields
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool|int
     */
    protected function validatePostalCode($attribute, $value, $parameters)
    {
        $this->requireParameterCount(2, $parameters, 'postal_code');
        $country = $this->addressing->findCountry($this->getValue($parameters[0]));
        if ($country instanceof Country) {
            $admAreaValue = $this->getValue($parameters[1]);
            $admArea = $country->findAdministrativeArea($admAreaValue);
            if ($admArea instanceof AdministrativeArea) {
                $postalCodePattern = $admArea->getPostalCodePattern();

                return preg_match("/^$postalCodePattern/", $value) === 1;
            }
        }

        return false;
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