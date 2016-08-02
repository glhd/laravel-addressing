<?php

use Galahad\LaravelAddressing\LaravelAddressing;

/**
 * Class LaravelAddressingTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LaravelAddressingTest extends PHPUnit_Framework_TestCase
{
    public function testGettingUS()
    {
        $addressing = new LaravelAddressing();
        $usCode = $addressing->getCountryByCode('US');
        $usName = $addressing->getCountryByName('United States');

        $this->assertEquals($usCode->getName(), 'United States');
        $this->assertEquals($usName->getCode(), 'US');
    }

    public function testCountryList()
    {
        $addressing = new LaravelAddressing();
        $countries = $addressing->getCountries(LaravelAddressing::ARRAY_LIST);

        $this->assertEquals($countries['US'], 'United States');
        $this->assertEquals($countries['BR'], 'Brazil');
    }
}