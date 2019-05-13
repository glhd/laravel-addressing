<?php

namespace Galahad\LaravelAddressing\Tests;

class RoutesTest extends TestCase
{
	public function test_a_list_of_countries_can_be_loaded_via_http() : void
	{
		$response = $this->get(route('galahad.addressing.countries'))
			->assertOk()
			->assertJsonStructure(['label', 'options']);
		
		$this->assertEquals('Countries', $response->json('label'));
		
		$options = $response->json('options');
		$country_codes = json_decode(file_get_contents(__DIR__.'/test-country-codes.json'), true);
		foreach ($country_codes as $country_code) {
			$this->assertArrayHasKey($country_code, $options);
		}
	}
	
	public function test_a_list_of_us_states_can_be_loaded_via_http() : void
	{
		$response = $this->get(route('galahad.addressing.administrative-areas', 'us'))
			->assertOk()
			->assertJsonStructure(['label', 'country_code', 'options']);
		
		$this->assertEquals('States', $response->json('label'));
		
		$options = $response->json('options');
		
		$state_codes = json_decode(file_get_contents(__DIR__.'/test-us-states.json'), true);
		foreach ($state_codes as $state_code) {
			$this->assertArrayHasKey($state_code, $options);
		}
	}
	
	public function test_canada_returns_province_for_label() : void
	{
		$response = $this->get(route('galahad.addressing.administrative-areas', 'ca'));
		
		$this->assertEquals('Provinces', $response->json('label'));
	}
}
