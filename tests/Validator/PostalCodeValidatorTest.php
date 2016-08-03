<?php

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
    }

    public function testColoradoPostalCode()
    {
        $defaultValues = ['country' => 'US', 'state' => 'CO'];
        $this->validator->setData(['postal_code' => '80301'] + $defaultValues);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '81000'] + $defaultValues);
        $this->assertTrue($this->validator->passes());

        $this->validator->setData(['postal_code' => '82000'] + $defaultValues);
        $this->assertFalse($this->validator->passes());
    }
}