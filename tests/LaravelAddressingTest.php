<?php

use Galahad\LaravelAddressing\Collection\CountryCollection;
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
        $this->addressing = LaravelAddressing::getInstance();
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

    public function testIfFindCountryMethodIsWorking()
    {
        $country = $this->addressing->findCountry('US');
        $this->assertEquals($country->getName(), 'United States');
        $country = $this->addressing->findCountry('United States');
        $this->assertEquals($country->getCountryCode(), 'US');
        $country = $this->addressing->findCountry('ZZZZZZZZZ');
        $this->assertTrue(is_null($country));
    }

    public function testIfCountriesMethodIsReturningACountryCollection()
    {
        $countries = $this->addressing->countries();
        $this->assertTrue($countries instanceof CountryCollection);
        /** @var Country $firstCountry */
        $firstCountry = $countries->first();
        $this->assertEquals($firstCountry->getName(), 'Afghanistan');
        $this->assertEquals($firstCountry->getCountryCode(), 'AF');
    }

    public function testIfUSAndBRCountriesExistInCountryList()
    {
        $countries = $this->addressing->countriesList();
        $this->assertTrue(isset($countries['US']));
        $this->assertTrue(isset($countries['BR']));
        $countries = array_flip($countries);
        $this->assertTrue(isset($countries['United States']));
        $this->assertTrue(isset($countries['Brazil']));
    }
}