<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Galahad\LaravelAddressing\LaravelAddressing;

class CountryCodeRule implements Rule
{
    /**
     * @var \Galahad\LaravelAddressing\LaravelAddressing
     */
    protected $addressing;

    /**
     * Constructor.
     *
     * @param \Galahad\LaravelAddressing\LaravelAddressing $addressing
     */
    public function __construct(LaravelAddressing $addressing)
    {
        $this->addressing = $addressing;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value) : bool
    {
        if (! is_string($value)) {
            return false;
        }

        return null !== $this->addressing->country($value);
    }

    /**
     * {@inheritdoc}
     */
    public function message() : string
    {
        return trans('laravel-addressing::validation.country_code');
    }
}
