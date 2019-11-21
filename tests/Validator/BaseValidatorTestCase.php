<?php

namespace Galahad\LaravelAddressing\Tests\Validator;

use Galahad\LaravelAddressing\Tests\TestCase;
use Illuminate\Validation\Factory;

/**
 * Class BaseValidatorTestCase.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class BaseValidatorTestCase extends TestCase
{
    /**
     * @var Factory
     */
    protected $validator;

    public function setUp() : void
    {
        parent::setUp();

        $this->validator = $this->app['validator'];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function performValidation(array $data)
    {
        $validator = $this->validator->make($data['data'], $data['rules']);

        return $validator->passes();
    }
}
