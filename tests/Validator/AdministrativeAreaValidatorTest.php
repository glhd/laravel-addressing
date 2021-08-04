<?php

namespace Galahad\LaravelAddressing\Tests\Validator;

/**
 * Class AdministrativeAreaValidatorTest.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidatorTest extends BaseValidatorTestCase
{
	public function test_mg_state_in_brazil()
	{
		$this->assertTrue($this->performValidation([
			'rules' => ['state' => 'administrative_area_code:country'],
			'data' => ['state' => 'MG', 'country' => 'BR'],
		]));
	}

	public function test_invalid_state_in_brazil()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'BR', 'state' => 'ZZ'],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

	public function test_co_state_in_united_states()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO'],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

	public function test_country_and_state_are_lower_case()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'us', 'state' => 'co'],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

	public function test_passes_if_country_has_no_admin_areas()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'GB', 'state' => ''],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

	public function test_admin_area_code_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => ['CO']],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

	public function test_admin_area_name_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => ['Colorado']],
			'rules' => ['state' => 'administrative_area_name:country'],
		]));
	}

	public function test_general_admin_area_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => ['CO']],
			'rules' => ['state' => 'administrative_area:country'],
		]));
	}

	public function test_us_state_by_name()
	{
		// Valid state in US
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Alabama'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
		// Invalid state name in US
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Allabama'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
	}

	public function test_state_using_country_name()
	{
		// Valid US state
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'United States', 'state' => 'Colorado'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
		// Invalid US state with wrong name
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'United States', 'state' => 'Collorado'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
	}

	public function test_general_administrative_area_validation()
	{
		// Valid US state
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'AL'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
		// Invalid US state
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'ZZ'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
		// Valid US state using its name
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Alabama'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
		// Invalid US state using its name
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Allabama'],
			'rules' => ['state' => 'administrative_area:country'],
		]));
	}

	public function test_uses_default_field_names()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO'],
			'rules' => ['state' => 'administrative_area_code'],
		]));

		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Colorado'],
			'rules' => ['state' => 'administrative_area_name'],
		]));

		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO'],
			'rules' => ['state' => 'administrative_area'],
		]));

		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Colorado'],
			'rules' => ['state' => 'administrative_area'],
		]));
	}

	public function test_allows_empty_administrative_areas_in_countries_where_it_is_optional()
	{
		// Empty county should be allowed in Ireland
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'IE', 'state' => ''],
			'rules' => ['state' => 'administrative_area'],
		]));

		// Valid county should be allowed in Ireland
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'IE', 'state' => 'Co. Clare'],
			'rules' => ['state' => 'administrative_area'],
		]));

		// Invalid county should not be allowed in Ireland
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'IE', 'state' => 'Pennsylvania'],
			'rules' => ['state' => 'administrative_area'],
		]));
	}

	public function test_allows_any_admin_area_in_countries_we_dont_have_data_for()
	{
		// As of right now, addressing doesn't have an admin area list for South Africa
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'ZA', 'state' => 'GP'],
			'rules' => ['state' => 'administrative_area'],
		]));
	}
}
