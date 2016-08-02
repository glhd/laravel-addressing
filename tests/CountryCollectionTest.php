<?php
use Galahad\LaravelAddressing\Country;
use Galahad\LaravelAddressing\CountryCollection;

/**
 * Class CountryCollectionTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testCountryCollectionClass()
    {
        $collection = new CountryCollection();
        $country = new Country;
        $countries = ['Brazil', 'United States', 'Argentina', 'Canada', 'Chile'];
        foreach ($countries as $countryName) {
            $collection->insert($country->getByName($countryName));
        }
        /** @var Country $country */
        foreach ($collection as $key => $country) {
            $this->assertEquals($country->getName(), $countries[$key]);
        }
    }

    public function testToListFeature()
    {
        $factory = new Country;
        $expected = ['BR' => 'Brazil', 'US' => 'United States'];
        $collection = new CountryCollection();
        $collection->insert([
            $factory->getByCode('BR'),
            $factory->getByCode('US'),
        ]);
        $this->assertEquals($collection->toList(), $expected);
    }
}