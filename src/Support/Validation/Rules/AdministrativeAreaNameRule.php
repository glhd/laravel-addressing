<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Galahad\LaravelAddressing\Entity\Country;
use Throwable;

class AdministrativeAreaNameRule implements Rule
{
    /**
     * @var \Galahad\LaravelAddressing\Entity\Country
     */
    protected $country;

    /**
     * Constructor.
     *
     * @param \Galahad\LaravelAddressing\Entity\Country $country
     */
    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value) : bool
    {
        try {
            $value = (string) $value;
        } catch (Throwable $exception) {
            return false;
        }

        return null !== $this->country->administrativeAreaByName($value);
    }

    /**
     * {@inheritdoc}
     */
    public function message() : string
    {
        $type = $this->country->addressFormat()->getAdministrativeAreaType();

        return trans('laravel-addressing::validation.administrative_area_name', compact('type'));
    }
}
