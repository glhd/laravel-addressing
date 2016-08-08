<?php

use CommerceGuys\Intl\Exception\UnknownCountryException;
use Galahad\LaravelAddressing\Validator\CountryValidator;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\Translator;

/**
 * Class CountryValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $rules = [
        'country_code' => 'country_code',
        'country_name' => 'country_name',
    ];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var Validator
     */
    protected $validator;

    protected function setUp()
    {
        $this->validator = new CountryValidator(new Translator($this->locale));
        $this->validator->setRules($this->rules);
    }

    public function testCountryCodeWithDifferentSize()
    {
        $this->validator->setData(['country_code' => 'ZZZ']);
        $this->assertFalse($this->validator->passes());
    }

    public function testCountryCodeWithCorrectSizeButInvalid()
    {
        $this->setExpectedException(UnknownCountryException::class);
        $this->validator->setData(['country_code' => 'ZZ']);
        $this->assertFalse($this->validator->passes());
    }

    public function testCorrectCountryCode()
    {
        $this->validator->setData(['country_code' => 'BR']);
        $this->assertTrue($this->validator->passes());
        $this->validator->setData(['country_code' => 'US']);
        $this->assertTrue($this->validator->passes());
    }

    public function testWrongCountryName()
    {
        $this->setExpectedException(UnknownCountryException::class);
        $this->validator->setData(['country_name' => 'United Stattes']);
        $this->assertFalse($this->validator->passes());
    }

    public function testCorrectCountryName()
    {
        $this->validator->setData(['country_name' => 'United States']);
        $this->assertTrue($this->validator->passes());
    }
}