<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Galahad\LaravelAddressing\Entity\Country;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class AdministrativeAreaCodeRule implements Rule
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
    public function passes($attribute, $value): bool
    {
        try {
            $value = (string) $value;
        } catch (Throwable $exception) {
            return false;
        }

        // If it's not required and empty, pass
        if ('' === $value && false === $this->isRequired()) {
            return true;
        }

        // If we don't have a known list of admin areas, just pass
        if (0 === $this->country->administrativeAreas()->count()) {
            return true;
        }

        return null !== $this->country->administrativeArea($value);
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        $type = $this->country->addressFormat()->getAdministrativeAreaType();

        return trans('laravel-addressing::validation.administrative_area_code', compact('type'));
    }

    protected function isRequired(): bool
    {
        return in_array('administrativeArea', $this->country->addressFormat()->getRequiredFields());
    }
}
