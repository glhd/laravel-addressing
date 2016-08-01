<?php

use Galahad\LaravelAddressing\AdministrativeArea;
use Galahad\LaravelAddressing\Country;

/**
 * Class CountryTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryTest extends PHPUnit_Framework_TestCase
{
    public function testFindByCodeAndName()
    {
        $country = new Country;

        $us = $country->findByName('United States');
        $br = $country->findByName('Brazil');
        $brazil = $country->findByCode('BR');

        $this->assertEquals($us->getCode(), 'US');
        $this->assertEquals($br->getCode(), 'BR');
        $this->assertEquals($brazil->getName(), 'Brazil');
    }

    public function testGetAdministrativeAreasFirstRow()
    {
        $country = new Country;

        $brazil = $country->findByCode('BR');
        $acState = $brazil->getAdministrativeAreas()->offsetGet(0);

        $us = $country->findByCode('US');
        $alabamaState = $us->getAdministrativeAreas()->offsetGet(0);
        $coloradoState = $us->getAdministrativeAreas()->offsetGet(9);

        $this->assertEquals($acState->getName(), 'Acre');
        $this->assertEquals($alabamaState->getName(), 'Alabama');
        $this->assertEquals($coloradoState->getName(), 'Colorado');
    }
}