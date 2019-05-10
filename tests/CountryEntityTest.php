<?php

namespace Galahad\LaravelAddressing\Tests;

use CommerceGuys\Addressing\Country\CountryRepository;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;
use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;

class CountryEntityTest extends TestCase
{
	/**
	 * @var \Galahad\LaravelAddressing\Entity\Country
	 */
	protected $country;
	
	/**
	 * @var string[]
	 */
	protected $test_state_codes;
	
	protected function setUp() : void
	{
		parent::setUp();
		
		$this->country = new Country(
			(new CountryRepository())->get('US'),
			new SubdivisionRepository()
		);
		
		$this->test_state_codes = json_decode(file_get_contents(__DIR__.'/test-us-states.json'), true);
	}
	
	public function test_it_should_be_able_to_list_its_administrative_areas() : void
	{
		foreach ($this->country->administrativeAreas() as $administrative_area) {
			/** @var AdministrativeArea $administrative_area */
			$this->assertInstanceOf(AdministrativeArea::class, $administrative_area);
			$this->assertContains($administrative_area->getCode(), $this->test_state_codes);
		}
	}
}
