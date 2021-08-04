<?php

namespace Galahad\LaravelAddressing\Tests\Validator;

/**
 * Class PostalCodeValidatorTest.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidatorTest extends BaseValidatorTestCase
{
	public function test_colorado_postal_code()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => '80301'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => '81000'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => '82000'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
	}

	public function test_array_postal_code_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => ['80301']],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
	}

	public function test_brazilian_postal_codes()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '31170-070'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '31310-190'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '21000-070'],
			'rules' => ['code' => 'postal_code:country,state'],
		]));
	}

	public function test_uses_default_field_names()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'administrative_area' => 'CO', 'code' => '80301'],
			'rules' => ['code' => 'postal_code'],
		]));
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => '80301'],
			'rules' => ['code' => 'postal_code'],
		]));
	}

	public function test_uses_country_reg_ex_if_no_admin_area()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'GB', 'administrative_area' => '', 'code' => 'NW4 2HX'],
			'rules' => ['code' => 'postal_code'],
		]));
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'GB', 'administrative_area' => '', 'code' => '1234567890'],
			'rules' => ['code' => 'postal_code'],
		]));
	}

	public function test_allows_empty_postal_codes_in_countries_where_it_is_optional()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'IE', 'administrative_area' => '', 'code' => ''],
			'rules' => ['code' => 'postal_code'],
		]));

		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'IE', 'administrative_area' => '', 'code' => '948723$&(#*'],
			'rules' => ['code' => 'postal_code'],
		]));
	}
}
