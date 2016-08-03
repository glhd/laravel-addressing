<?php

use Galahad\LaravelAddressing\Validator\AdministrativeAreaValidator;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\Translator;

/**
 * Class AdministrativeAreaValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $rules = [
        'state_code' => 'administrative_area_code:country',
        'state_name' => 'administrative_area_name:country',
        'state' => 'administrative_area:country',
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
        $this->validator = new AdministrativeAreaValidator(new Translator($this->locale));
        $this->validator->setRules($this->rules);
    }

    public function testMGStateInBrazil()
    {
        $this->validator->setData([
            'country' => 'BR',
            'state_code' => 'MG',
        ]);
        $this->assertTrue($this->validator->passes());
    }

    public function testInvalidStateInBrazil()
    {
        $this->validator->setData([
            'country' => 'BR',
            'state_code' => 'ZZ',
        ]);
        $this->assertFalse($this->validator->passes());
    }

    public function testCOStateInUnitedStates()
    {
        $this->validator->setData([
            'country' => 'US',
            'state_code' => 'CO',
        ]);
        $this->assertTrue($this->validator->passes());
    }

    public function testUSStateByName()
    {
        // Valid state in US
        $this->validator->setData([
            'country' => 'US',
            'state_name' => 'Alabama',
        ]);
        $this->assertTrue($this->validator->passes());
        // Invalid state name in US
        $this->validator->setData([
            'country' => 'US',
            'state_name' => 'Allabama',
        ]);
        $this->assertFalse($this->validator->passes());
    }

    public function testStateUsingCountryName()
    {
        // Valid US state
        $this->validator->setData([
            'country' => 'United States',
            'state_name' => 'Colorado',
        ]);
        $this->assertTrue($this->validator->passes());
        // Invalid US state with wrong name
        $this->validator->setData([
            'country' => 'United States',
            'state_name' => 'Collorado',
        ]);
        $this->assertFalse($this->validator->passes());
    }

    public function testGeneralAdministrativeAreaValidation()
    {
        // Valid US state
        $this->validator->setData([
            'country' => 'US',
            'state' => 'AL',
        ]);
        $this->assertTrue($this->validator->passes());
        // Invalid US state
        $this->validator->setData([
            'country' => 'US',
            'state' => 'ZZ',
        ]);
        $this->assertFalse($this->validator->passes());
        // Valid US state using its name
        $this->validator->setData([
            'country' => 'US',
            'state' => 'Alabama',
        ]);
        $this->assertTrue($this->validator->passes());
        // Invalid US state using its name
        $this->validator->setData([
            'country' => 'US',
            'state' => 'Allabama',
        ]);
        $this->assertFalse($this->validator->passes());
    }
}