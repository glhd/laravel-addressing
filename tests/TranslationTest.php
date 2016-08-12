<?php

use Galahad\LaravelAddressing\ServiceProvider;
use Illuminate\Validation\Factory;
use Orchestra\Testbench\TestCase;

/**
 * Class TranslationTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class TranslationTest extends TestCase
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

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function testENMessages()
    {
        $this->app->setLocale('en');
        $validator = $this->validator->make(
            ['country' => 'ZZ'],
            ['country' => 'country_code']
        );
        if ($validator->fails()) {
            $messages = $validator->errors()->get('country');
            $first = array_shift($messages);
            $this->assertEquals($first, 'The country field is not a valid country code.');
        }
    }

    public function testPT_BRMessages()
    {
        $this->app->setLocale('pt-br');
        $validator = $this->validator->make(
            ['country' => 'ZZ'],
            ['country' => 'country_code']
        );
        if ($validator->fails()) {
            $messages = $validator->errors()->get('country');
            $first = array_shift($messages);
            $this->assertEquals($first, 'O campo country não possui um código de país válido.');
        }
    }

    public function testENMessagesForAdministrativeAreaValidator()
    {
        $this->app->setLocale('en');
        $validator = $this->validator->make(
            ['country' => 'US', 'state' => 'COO'],
            ['country' => 'country_code', 'state' => 'administrative_area:country']
        );
        if ($validator->fails()) {
            $messages = $validator->errors()->get('state');
            $first = array_shift($messages);
            $this->assertEquals($first, 'The state field is not a valid state/province.');
        }
    }
}