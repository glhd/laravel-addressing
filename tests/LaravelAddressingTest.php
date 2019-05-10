<?php

namespace Galahad\LaravelAddressing\Tests;

// use CommerceGuys\Intl\Exception\UnknownCountryException;
use Galahad\LaravelAddressing\Collection\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Entity\AdministrativeArea;
use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;

class LaravelAddressingTest extends TestCase
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;
    
    protected function setUp() : void
    {
    	parent::setUp();
    	
        $this->addressing = new LaravelAddressing();
    }

    public function test_TheReturningTypeOfCountryMethod() : void
    {
        $country = $this->addressing->country('US');
        $this->assertTrue($country instanceof Country);
    }

    public function test_IfTheCountryHasTheCorrectName() : void
    {
        $country = $this->addressing->country('US');
        $this->assertEquals($country->getName(), 'United States');
        $this->assertEquals($country->getCountryCode(), 'US');
    }

    public function test_IfTheCountryByNameMethodIsReturningTheCorrectCountry() : void
    {
        $country = $this->addressing->countryByName('United States');
        $this->assertTrue($country instanceof Country);
        $this->assertEquals($country->getCountryCode(), 'US');
        $country = $this->addressing->countryByName('Brazil');
        $this->assertEquals($country->getCountryCode(), 'BR');
    }

    public function test_IfFindCountryMethodIsWorking() : void
    {
        $country = $this->addressing->findCountry('US');
        $this->assertEquals($country->getName(), 'United States');
        $country = $this->addressing->findCountry('United States');
        $this->assertEquals($country->getCountryCode(), 'US');
        $this->setExpectedException(UnknownCountryException::class);
        $country = $this->addressing->findCountry('ZZZZZZZZZ');
    }

    public function test_IfCountriesMethodIsReturningACountryCollection() : void
    {
        $countries = $this->addressing->countries();
        $this->assertTrue($countries instanceof CountryCollection);
        /** @var Country $firstCountry */
        $firstCountry = $countries->first();
        $this->assertEquals($firstCountry->getName(), 'Afghanistan');
        $this->assertEquals($firstCountry->getCountryCode(), 'AF');
    }

    public function test_IfUSAndBRCountriesExistInCountryList() : void
    {
        $countries = $this->addressing->countriesList();
        $this->assertTrue(isset($countries['US']));
        $this->assertTrue(isset($countries['BR']));
        $countries = array_flip($countries);
        $this->assertTrue(isset($countries['United States']));
        $this->assertTrue(isset($countries['Brazil']));
    }

    public function test_IfAdministrativeAreasMethodReturnsAAdministrativeAreaCollection() : void
    {
        $country = $this->addressing->country('US');
        $this->assertTrue($country->administrativeAreas() instanceof AdministrativeAreaCollection);
    }

    public function test_IfSomeUSStatesMatch() : void
    {
        $country = $this->addressing->country('US');
        /** @var AdministrativeArea $firstAdministrativeArea */
        $firstAdministrativeArea = $country->administrativeAreas()->first();
        $this->assertTrue($firstAdministrativeArea instanceof AdministrativeArea);
        $this->assertEquals($firstAdministrativeArea->getName(), 'Alabama');
    }

    public function test_IfSomeBrazilianStatesMatch() : void
    {
        $country = $this->addressing->country('BR');
        /** @var AdministrativeArea $firstAdministrativeArea */
        $firstAdministrativeArea = $country->administrativeAreas()->first();
        $this->assertEquals($firstAdministrativeArea->getName(), 'Acre');
        $this->assertEquals($firstAdministrativeArea->getCode(), 'AC');
        $this->assertEquals($firstAdministrativeArea->getCountryCode(), 'BR');
    }

    public function test_GettingASpecificAdministrativeAreaInUS() : void
    {
        $country = $this->addressing->country('US');
        $colorado = $country->administrativeArea('US-CO');
        $this->assertEquals($colorado->getName(), 'Colorado');
        $alabama = $country->administrativeArea('US-AL');
        $this->assertEquals($alabama->getName(), 'Alabama');
    }

    public function test_GettingASpecificAdministrativeAreaWithoutTheCountryCode() : void
    {
        $country = $this->addressing->country('US');
        $colorado = $country->administrativeArea('CO');
        $this->assertEquals($colorado->getName(), 'Colorado');
        $alabama = $country->administrativeArea('AL');
        $this->assertEquals($alabama->getName(), 'Alabama');
    }

    public function test_FindAdministrativeArea() : void
    {
        $country = $this->addressing->country('US');
        $alabama = $country->findAdministrativeArea('AL');
        $this->assertEquals($alabama->getName(), 'Alabama');
        $alabama = $country->findAdministrativeArea('Alabama');
        $this->assertEquals($alabama->getCode(), 'AL');
    }

    public function test_IsCaseInsensitive() : void
    {
        $country = $this->addressing->country('us');
        $alabama = $country->findAdministrativeArea('al');
        $this->assertEquals($alabama->getName(), 'Alabama');
        $alabama = $country->findAdministrativeArea('alabama');
        $this->assertEquals($alabama->getCode(), 'AL');
    }
}
