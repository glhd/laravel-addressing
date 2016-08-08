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

    /**
     * Testing the returning type of the country() method
     */
    public function testCountryMethodReturningType()
    {
        $country = $this->addressing->country('US');
        $this->assertTrue($country instanceof Country);
    }

    /**
     * Testing if the country has the correct name
     */
    public function testCountryMethod()
    {
        $country = $this->addressing->country('US');
        $this->assertEquals($country->getName(), 'United States');
        $this->assertEquals($country->getCountryCode(), 'US');
    }
}