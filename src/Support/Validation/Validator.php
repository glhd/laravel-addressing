<?php

namespace Galahad\LaravelAddressing\Support\Validation;

use Illuminate\Support\Arr;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Entity\Subdivision;
use Illuminate\Validation\Validator as BaseValidator;
use Galahad\LaravelAddressing\Support\Validation\Rules\PostalCodeRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\CountryCodeRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\CountryNameRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\LooseCountryRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\AdministrativeAreaCodeRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\AdministrativeAreaNameRule;
use Galahad\LaravelAddressing\Support\Validation\Rules\LooseAdministrativeAreaRule;

class Validator
{
    /**
     * @var \Galahad\LaravelAddressing\LaravelAddressing
     */
    protected $addressing;

    /**
     * Validator constructor.
     *
     * @param \Galahad\LaravelAddressing\LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }

    /**
     * Validate that the input is a country code.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function countryCode($attribute, $value) : bool
    {
        return (new CountryCodeRule($this->addressing))->passes($attribute, $value);
    }

    /**
     * Validate that the input is a country name.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function countryName($attribute, $value) : bool
    {
        return (new CountryNameRule($this->addressing))->passes($attribute, $value);
    }

    /**
     * Validate that the input is a country name or code.
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function looseCountry($attribute, $value) : bool
    {
        return (new LooseCountryRule($this->addressing))->passes($attribute, $value);
    }

    /**
     * Validate that the input is an administrative code.
     *
     * @param $attribute
     * @param $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function administrativeArea($attribute, $value, array $parameters, BaseValidator $validator) : bool
    {
        if (! $country = $this->loadCountryFromValidationData($parameters, $validator)) {
            return false;
        }

        return (new AdministrativeAreaCodeRule($country))->passes($attribute, $value);
    }

    /**
     * Validate that the input is an administrative area name.
     *
     * @param $attribute
     * @param $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function administrativeAreaName($attribute, $value, array $parameters, BaseValidator $validator) : bool
    {
        if (! $country = $this->loadCountryFromValidationData($parameters, $validator)) {
            return false;
        }

        return (new AdministrativeAreaNameRule($country))->passes($attribute, $value);
    }

    /**
     * Validate that the input is an administrative area name or code.
     *
     * @param $attribute
     * @param $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function looseAdministrativeArea($attribute, $value, array $parameters, BaseValidator $validator) : bool
    {
        if (! $country = $this->loadCountryFromValidationData($parameters, $validator)) {
            return false;
        }

        return (new LooseAdministrativeAreaRule($country))->passes($attribute, $value);
    }

    /**
     * Validate a postal code.
     *
     * @param $attribute
     * @param string $value
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return bool
     */
    public function postalCode($attribute, $value, array $parameters, BaseValidator $validator) : bool
    {
        if (! $country = $this->loadCountryFromValidationData($parameters, $validator)) {
            return false;
        }

        $administrative_area = $this->loadAdministrativeAreaFromValidationData($country, $parameters, $validator);

        return (new PostalCodeRule($country, $administrative_area))->passes($attribute, $value);
    }

    /**
     * This tries to resolve the entity for the requested country based
     * on the data under validation. Eg. ?country=CA should resolve to the
     * Canada country entity.
     *
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return \Galahad\LaravelAddressing\Entity\Country|null
     */
    protected function loadCountryFromValidationData(array $parameters, BaseValidator $validator) : ?Country
    {
        $country_input_name = $parameters[0] ?? 'country';

        if (! $country_value = Arr::get($validator->getData(), $country_input_name)) {
            return null;
        }

        return $this->addressing->findCountry($country_value);
    }

    /**
     * This tries to resolve the entity for the requested subdivision based
     * on the data under validation. Eg. ?state=PA should resolve to the
     * United States -> Pennsylvania subdivision entity.
     *
     * @param \Galahad\LaravelAddressing\Entity\Country $country
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return \Galahad\LaravelAddressing\Entity\Subdivision|null
     */
    protected function loadAdministrativeAreaFromValidationData(Country $country, array $parameters, BaseValidator $validator) : ?Subdivision
    {
        if (! $administrative_area_value = $this->loadAdministrativeAreaValueFromValidationData($parameters, $validator)) {
            return null;
        }

        return $country->findAdministrativeArea($administrative_area_value);
    }

    /**
     * This looks through the data under validation and tries to get the value
     * for the current state/province using common input names like "state" or "province".
     *
     * @param array $parameters
     * @param \Illuminate\Validation\Validator $validator
     * @return string|null
     */
    protected function loadAdministrativeAreaValueFromValidationData(array $parameters, BaseValidator $validator) : ?string
    {
        // Either use the explicitly set name, or try all common names
        $possible_input_names = isset($parameters[1])
            ? [$parameters[1]]
            : ['administrative_area', 'state', 'province'];

        $data = $validator->getData();
        foreach ($possible_input_names as $input_name) {
            if ($value = Arr::get($data, $input_name)) {
                return $value;
            }
        }

        return null;
    }
}
