<?php

namespace Galahad\LaravelAddressing\Support\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Entity\Subdivision;
use CommerceGuys\Addressing\Subdivision\PatternType;

class PostalCodeRule implements Rule
{
    /**
     * @var \Galahad\LaravelAddressing\Entity\Country
     */
    protected $country;

    /**
     * @var \Galahad\LaravelAddressing\Entity\Subdivision|null
     */
    protected $administrative_area;

    /**
     * Constructor.
     *
     * @param \Galahad\LaravelAddressing\Entity\Country $country
     * @param \Galahad\LaravelAddressing\Entity\Subdivision|null $administrative_area
     */
    public function __construct(Country $country, Subdivision $administrative_area = null)
    {
        $this->country = $country;
        $this->administrative_area = $administrative_area;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value) : bool
    {
        if (! is_string($value)) {
            return false;
        }

        // If we don't have a pattern for this country/area, automatically pass
        if (! $pattern = $this->pattern()) {
            return true;
        }

        return preg_match($pattern, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function message() : string
    {
        $type = $this->country->addressFormat()->getPostalCodeType() ?? 'postal code';

        return trans('laravel-addressing::validation.postal_code', compact('type'));
    }

    protected function pattern() : ?string
    {
        $pattern = $this->administrative_area
            ? $this->administrative_area->getPostalCodePattern()
            : $this->country->addressFormat()->getPostalCodePattern();

        $pattern_type = $this->administrative_area
            ? $this->administrative_area->getPostalCodePatternType()
            : PatternType::FULL;

        if (PatternType::START === $pattern_type) {
            return '/^'.$pattern.'/i';
        }

        return '/'.$pattern.'/i';
    }
}
