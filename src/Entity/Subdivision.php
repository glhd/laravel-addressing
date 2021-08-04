<?php

namespace Galahad\LaravelAddressing\Entity;

use CommerceGuys\Addressing\Subdivision\PatternType;
use CommerceGuys\Addressing\Subdivision\Subdivision as BaseSubdivision;
use Galahad\LaravelAddressing\Collection\SubdivisionCollection;

/**
 * @property-read \Galahad\LaravelAddressing\Entity\Subdivision $parent
 * @property-read string $country_code
 * @property-read string|null $locale
 * @property-read string $code
 * @property-read string|null $local_code
 * @property-read string $name
 * @property-read string|null $local_name
 * @property-read string|null $iso_code
 * @property-read string|null $postal_code_pattern
 * @property-read string $postal_code_pattern_type
 * @property-read \CommerceGuys\Addressing\Subdivision\Subdivision[] $children
 *
 * @mixin \CommerceGuys\Addressing\Subdivision\Subdivision
 */
class Subdivision
{
	use DecoratesEntity;
	
	protected BaseSubdivision $subdivision;
	
	protected Country $country;
	
	protected ?Subdivision $parent = null;
	
	protected ?SubdivisionCollection $children = null;

	public function __construct(Country $country, BaseSubdivision $subdivision, self $parent = null)
	{
		$this->subdivision = $subdivision;

		// parent is loaded, children is lazy loaded
		$this->country = $country;
		$this->parent = $parent;
	}

	public function getCountry(): Country
	{
		return $this->country;
	}

	public function getParent(): ?self
	{
		if (null === $this->parent && $base_parent = $this->subdivision->getParent()) {
			$this->parent = new self($this->country, $base_parent);
		}

		return $this->parent;
	}

	public function getPostalCodePattern(): ?string
	{
		return $this->subdivision->getPostalCodePattern()
			?? $this->country->addressFormat()->getPostalCodePattern();
	}

	public function getPostalCodePatternType(): string
	{
		return $this->subdivision->getPostalCodePatternType() ?? PatternType::FULL;
	}

	public function getLocale(): string
	{
		return $this->subdivision->getLocale() ?? $this->country->getLocale();
	}

	public function getChildren(): SubdivisionCollection
	{
		if (null === $this->children) {
			$this->children = SubdivisionCollection::make()->setCountry($this->country)->setParent($this);
			foreach ($this->subdivision->getChildren() as $child) {
				$this->children->put($child->getCode(), new self($this->country, $child, $this));
			}
		}

		return $this->children;
	}

	public function is(self $subdivision = null): bool
	{
		if (null === $subdivision) {
			return false;
		}

		if (!$this->getCode() === $subdivision->getCode()) {
			return false;
		}

		if (!$this->getCountry()->is($subdivision->getCountry())) {
			return false;
		}

		if ($parent = $this->getParent()) {
			return $parent->is($subdivision->getParent());
		}

		return $parent === $subdivision->getParent();
	}

	public function __call($name, $arguments)
	{
		return $this->subdivision->$name(...$arguments);
	}
	
	protected function decoratedEntity()
	{
		return $this->subdivision;
	}
}
