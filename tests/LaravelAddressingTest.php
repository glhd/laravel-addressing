<?php

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;

/**
 * Class LaravelAddressingTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LaravelAddressingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * Setup the LaravelAddressing instance
     */
    protected function setUp()
    {
        $this->addressing = new LaravelAddressing();
    }

    public function testTheReturningTypeOfCountryMethod()
    {
        $country = $this->addressing->country('US');
        $this->assertTrue($country instanceof Country);
    }

    public function testIfTheCountryHasTheCorrectName()
    {
        $country = $this->addressing->country('US');
        $this->assertEquals($country->getName(), 'United States');
        $this->assertEquals($country->getCountryCode(), 'US');
    }

    public function testIfTheCountryByNameMethodIsReturningTheCorrectCountry()
    {
        $country = $this->addressing->countryByName('United States');
        $this->assertTrue($country instanceof Country);
        $this->assertEquals($country->getCountryCode(), 'US');
        $country = $this->addressing->countryByName('Brazil');
        $this->assertEquals($country->getCountryCode(), 'BR');
    }
}