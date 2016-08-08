<?php

namespace Galahad\LaravelAddressing\Validator;

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CountryValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidator extends Validator
{
    /**
     * The validator messages
     *
     * @var array
     */
    protected $messages = [
        'country_name' => 'The :attribute has not a valid country name.',
        'country_code' => 'The :attribute has not a valid country code.',
    ];

    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * The constructor method
     *
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
        $this->addressing = LaravelAddressing::getInstance();
    }

    /**
     * Validate a country by its name
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateCountryName($attribute, $value)
    {
        $country = $this->addressing->countryByName($value);

        return $country instanceof Country;
    }

    /**
     * Validate a country by its code
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateCountryCode($attribute, $value)
    {
        if ($this->getSize($attribute, $value) == 2) {
            $country = $this->addressing->country($value);

            return $country instanceof Country;
        }

        return false;
    }
}
