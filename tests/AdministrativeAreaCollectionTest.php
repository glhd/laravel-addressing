<?php

use Galahad\LaravelAddressing\AdministrativeAreaCollection;
use Galahad\LaravelAddressing\Country;

/**
 * Class AdministrativeAreaCollectionTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testCollectionClass()
    {
        $country = new Country;
        $brazil = $country->getByCode('BR');
        $states = $brazil->getAdministrativeAreas();

        $this->assertInstanceOf(AdministrativeAreaCollection::class, $states);
    }

    public function testUSStatesCount()
    {
        $country = new Country;
        $us = $country->getByCode('US');
        $states = $us->getAdministrativeAreas();

        $this->assertEquals($states->count(), 62);
    }
}