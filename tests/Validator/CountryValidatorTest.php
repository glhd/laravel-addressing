<?php

namespace Galahad\LaravelAddressing\Tests\Validator;

/**
 * Class CountryValidatorTest.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidatorTest extends BaseValidatorTestCase
{
	public function test_country_code_with_different_size()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'USA'],
			'rules' => ['country' => 'country_code'],
		]));
	}

	public function test_country_code_with_correct_size_but_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'ZZ'],
			'rules' => ['country' => 'country_code'],
		]));
	}

	public function test_country_code_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => ['US']],
			'rules' => ['country' => 'country_code'],
		]));
	}

	public function test_correct_country_code()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'BR'],
			'rules' => ['country' => 'country_code'],
		]));
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US'],
			'rules' => ['country' => 'country_code'],
		]));
	}

	public function test_wrong_country_name()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'United Stattes'],
			'rules' => ['country' => 'country_name'],
		]));
	}

	public function test_country_name_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => ['United States']],
			'rules' => ['country' => 'country_name'],
		]));
	}

	public function test_correct_country_name()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'United States'],
			'rules' => ['country' => 'country_name'],
		]));
	}

	public function test_general_country_validation()
	{
		// Valid country code
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US'],
			'rules' => ['country' => 'country'],
		]));
		// Invalid country code
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'ZZ'],
			'rules' => ['country' => 'country'],
		]));
		// Valid country using its name
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'United States'],
			'rules' => ['country' => 'country'],
		]));
		// Invalid country using its name
		$this->assertFalse($this->performValidation([
			'data' => ['country' => 'United Stattes'],
			'rules' => ['country' => 'country'],
		]));
	}

	public function test_general_country_array_is_invalid()
	{
		$this->assertFalse($this->performValidation([
			'data' => ['country' => ['United States']],
			'rules' => ['country' => 'country'],
		]));
	}
}
