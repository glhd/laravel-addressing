<?php

namespace Galahad\LaravelAddressing\Tests;

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\Exceptions\CountryNotFoundException;
use Galahad\LaravelAddressing\LaravelAddressing;

class LaravelAddressingTest extends TestCase
{
	protected LaravelAddressing $addressing;

	protected $test_iso_codes;

	protected function setUp(): void
	{
		parent::setUp();

		$this->addressing = $this->app->make(LaravelAddressing::class);
		$this->test_iso_codes = json_decode(file_get_contents(__DIR__.'/test-country-codes.json'), true);
	}

	public function test_a_country_can_be_loaded_via_its_iso_code(): void
	{
		foreach ($this->test_iso_codes as $country_code) {
			$this->assertInstanceOf(Country::class, $this->addressing->country($country_code));
		}
	}

	public function test_the_case_of_the_country_code_does_not_matter(): void
	{
		$lower = $this->addressing->country('us');
		$upper = $this->addressing->country('US');
		$mixed = $this->addressing->country('Us');

		$this->assertTrue($lower->is($upper));
		$this->assertTrue($upper->is($mixed));
		$this->assertTrue($mixed->is($lower));
	}

	public function test_it_returns_null_when_an_unknown_country_code_is_provided(): void
	{
		$this->assertNull($this->addressing->country('XX'));
	}
	
	public function test_it_triggers_an_exception_when_using_or_fail_method(): void
	{
		$this->expectException(CountryNotFoundException::class);
		
		$this->addressing->countryOrFail('XX');
	}

	public function test_a_country_can_be_loaded_by_its_name(): void
	{
		$by_name = $this->addressing->countryByName('united states');
		$by_code = $this->addressing->country('US');

		$this->assertTrue($by_name->is($by_code));
	}

	public function test_a_collection_of_all_countries_can_be_loaded(): void
	{
		$this->assertGreaterThanOrEqual(256, $this->addressing->countries()->count());
	}

	public function test_a_country_can_be_found_with_input_that_may_be_a_code_or_name(): void
	{
		$by_name = $this->addressing->findCountry('united states');
		$by_code = $this->addressing->findCountry('US');

		$this->assertTrue($by_name->is($by_code));
	}
}
