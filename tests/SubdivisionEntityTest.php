<?php

namespace Galahad\LaravelAddressing\Tests;

use Galahad\LaravelAddressing\Support\Facades\Addressing;

class SubdivisionEntityTest extends TestCase
{
	public function test_subdivisions_expose_their_country(): void
	{
		$usa = Addressing::country('US');
		$colorado = $usa->administrativeArea('CO');
		$pennsylvania = $usa->administrativeArea('PA');

		$this->assertTrue($colorado->getCountry()->is($pennsylvania->getCountry()));
	}

	public function test_subdivisions_can_be_compared(): void
	{
		$usa = Addressing::country('US');
		$colorado = $usa->administrativeArea('CO');
		$colorado2 = $usa->administrativeArea('CO');
		$pennsylvania = $usa->administrativeArea('PA');

		$this->assertTrue($colorado->is($colorado2));
		$this->assertFalse($colorado->is($pennsylvania));
	}
	
	public function test_attributes_can_get_accessed_as_properties(): void
	{
		$usa = Addressing::country('US');
		$colorado = $usa->administrativeArea('CO');
		
		$this->assertEquals($colorado->getParent(), $colorado->parent);
		$this->assertEquals($colorado->getCountryCode(), $colorado->country_code);
		$this->assertEquals($colorado->getLocale(), $colorado->locale);
		$this->assertEquals($colorado->getCode(), $colorado->code);
		$this->assertEquals($colorado->getLocalCode(), $colorado->local_code);
		$this->assertEquals($colorado->getName(), $colorado->name);
		$this->assertEquals($colorado->getLocalName(), $colorado->local_name);
		$this->assertEquals($colorado->getIsoCode(), $colorado->iso_code);
		$this->assertEquals($colorado->getPostalCodePattern(), $colorado->postal_code_pattern);
		$this->assertEquals($colorado->getPostalCodePatternType(), $colorado->postal_code_pattern_type);
	}
}
