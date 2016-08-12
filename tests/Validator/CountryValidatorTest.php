<?php

require __DIR__.'/BaseValidatorTestCase.php';

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
            'value' => 'USA',
            'rule' => 'country_code',
            'field' => 'country',
        ]));
    }

    public function testCountryCodeWithCorrectSizeButInvalid()
    {
        $this->assertFalse($this->performValidation([
            'value' => 'ZZ',
            'rule' => 'country_code',
            'field' => 'country',
        ]));
    }

    public function testCorrectCountryCode()
    {
        $this->assertTrue($this->performValidation([
            'value' => 'BR',
            'rule' => 'country_code',
            'field' => 'country',
        ]));
        $this->assertTrue($this->performValidation([
            'value' => 'US',
            'rule' => 'country_code',
            'field' => 'country',
        ]));
    }

    public function testWrongCountryName()
    {
        $this->assertFalse($this->performValidation([
            'value' => 'United Stattes',
            'rule' => 'country_name',
            'field' => 'country',
        ]));
    }

    public function testCorrectCountryName()
    {
        $this->assertTrue($this->performValidation([
            'value' => 'United States',
            'rule' => 'country_name',
            'field' => 'country',
        ]));
    }
}