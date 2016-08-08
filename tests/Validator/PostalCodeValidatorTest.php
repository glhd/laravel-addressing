<?php

use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Validator\PostalCodeValidator;
use Illuminate\Validation\Validator;
use Symfony\Component\Translation\Translator;

/**
 * Class PostalCodeValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $rules = [
        'postal_code' => 'postal_code:country,state',
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
        $this->validator = new PostalCodeValidator(new Translator($this->locale));
        $this->validator->setRules($this->rules);
        $this->validator->setAddressing(new LaravelAddressing($this->locale));
    }

    public function testColoradoPostalCode()
    {
        $default = ['country' => 'US', 'state' => 'CO'];
        $this->validator->setData(['postal_code' => '80301'] + $default);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '81000'] + $default);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '82000'] + $default);
        $this->assertFalse($this->validator->passes());
    }

    public function testBrazilianPostalCodes()
    {
        $default = ['country' => 'BR', 'state' => 'MG'];
        $this->validator->setData(['postal_code' => '31170-070'] + $default);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '31310-190'] + $default);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '21000-000'] + $default);
        $this->assertFalse($this->validator->passes());
    }
}