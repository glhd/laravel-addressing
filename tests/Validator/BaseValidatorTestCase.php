<?php

use Galahad\LaravelAddressing\ServiceProvider;
use Illuminate\Validation\Factory;
use Orchestra\Testbench\TestCase;

/**
 * Class BaseValidatorTestCase
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class BaseValidatorTestCase extends TestCase
{
    /**
     * @var Factory
     */
    protected $validator;

    public function setUp()
    {
        parent::setUp();
        $this->validator = $this->app['validator'];
    }

    /**
     * Load the custom Service Provider class
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
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