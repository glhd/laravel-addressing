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

    /**
     * @var string
     */
    protected $translationDirectory;

    public function setUp()
    {
        parent::setUp();
        $this->validator = $this->app['validator'];
        $this->translationDirectory = __DIR__.'/../lang';
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getMessage($locale, $filename, $key, $field)
    {
        $filePath = sprintf('%s/%s/%s.php', $this->translationDirectory, $locale, $filename);
        $arrayContent = include $filePath;

        if (isset($arrayContent[$key])) {
            return str_replace(':attribute', $field, $arrayContent[$key]);
        }
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
            $expectedMessage = $this->getMessage('en', 'validation', 'country_code', 'country');
            $this->assertEquals($first, $expectedMessage);
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
            $expectedMessage = $this->getMessage('pt-br', 'validation', 'country_code', 'country');
            $this->assertEquals($first, $expectedMessage);
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
            $expectedMessage = $this->getMessage('en', 'validation', 'administrative_area', 'state');
            $this->assertEquals($first, $expectedMessage);
        }
    }
}