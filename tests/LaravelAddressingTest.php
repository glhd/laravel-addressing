<?php

use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\AdministrativeArea;
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

    public function testIfAdministrativeAreasMethodReturnsAAdministrativeAreaCollection()
    {
        $country = $this->addressing->country('US');
        $this->assertTrue($country->administrativeAreas() instanceof AdministrativeAreaCollection);
    }

    public function testIfSomeUSStatesMatch()
    {
        $country = $this->addressing->country('US');
        /** @var AdministrativeArea $firstAdministrativeArea */
        $firstAdministrativeArea = $country->administrativeAreas()->first();
        $this->assertTrue($firstAdministrativeArea instanceof AdministrativeArea);
        $this->assertEquals($firstAdministrativeArea->getName(), 'Alabama');
    }

    public function testIfSomeBrazilianStatesMatch()
    {
        $country = $this->addressing->country('BR');
        /** @var AdministrativeArea $firstAdministrativeArea */
        $firstAdministrativeArea = $country->administrativeAreas()->first();
        $this->assertEquals($firstAdministrativeArea->getName(), 'Acre');
        $this->assertEquals($firstAdministrativeArea->getCode(), 'AC');
        $this->assertEquals($firstAdministrativeArea->getCountryCode(), 'BR');
    }

    public function testGettingASpecificAdministrativeAreaInUS()
    {
        $country = $this->addressing->country('US');
        $colorado = $country->administrativeArea('US-CO');
        $this->assertEquals($colorado->getName(), 'Colorado');
        $alabama = $country->administrativeArea('US-AL');
        $this->assertEquals($alabama->getName(), 'Alabama');
    }

    public function testGettingASpecificAdministrativeAreaWithoutTheCountryCode()
    {
        $country = $this->addressing->country('US');
        $colorado = $country->administrativeArea('CO');
        $this->assertEquals($colorado->getName(), 'Colorado');
        $alabama = $country->administrativeArea('AL');
        $this->assertEquals($alabama->getName(), 'Alabama');
    }
}