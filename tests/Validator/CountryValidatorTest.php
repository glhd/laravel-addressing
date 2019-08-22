<?php

namespace Galahad\LaravelAddressing\Tests\Validator;

/**
 * Class CountryValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidatorTest extends BaseValidatorTestCase
{
    public function testCountryCodeWithDifferentSize()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'USA'],
            'rules' => ['country' => 'country_code'],
        ]));
    }

    public function testCountryCodeWithCorrectSizeButInvalid()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'ZZ'],
            'rules' => ['country' => 'country_code'],
        ]));
    }

    public function testCountryCodeArrayIsInvalid()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => ['US']],
            'rules' => ['country' => 'country_code'],
        ]));
    }

    public function testCorrectCountryCode()
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

    public function testWrongCountryName()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'United Stattes'],
            'rules' => ['country' => 'country_name'],
        ]));
    }

    public function testCountryNameArrayIsInvalid()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => ['United States']],
            'rules' => ['country' => 'country_name'],
        ]));
    }

    public function testCorrectCountryName()
    {
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'United States'],
            'rules' => ['country' => 'country_name'],
        ]));
    }

    public function testGeneralCountryValidation()
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

    public function testGeneralCountryArrayIsInvalid()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => ['United States']],
            'rules' => ['country' => 'country'],
        ]));
    }
}
