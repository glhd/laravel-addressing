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
            $collection->insert($country->findByName($countryName));
        }
        /** @var Country $country */
        foreach ($collection as $key => $country) {
            $this->assertEquals($country->getName(), $countries[$key]);
        }
    }
}