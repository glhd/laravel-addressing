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

    public function testBrazilianStatesCount()
    {
        $country = new Country;
        $brazil = $country->getByName('Brazil');
        $states = $brazil->getAdministrativeAreas();

        $this->assertEquals($states->count(), 27);
        $this->assertEquals($brazil->states()->count(), 27);
    }

    public function testCollectionList()
    {
        $country = new Country();
        $usStates = $country->getByCode('US')->getAdministrativeAreas()->toList();

        $this->assertTrue(isset($usStates['AL']));
        $this->assertTrue(isset($usStates['CO']));
        $this->assertTrue(isset($usStates['CA']));
    }
}