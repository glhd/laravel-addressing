<?php

use Galahad\LaravelAddressing\Country;

/**
 * Class AdministrativeAreaTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaTest extends PHPUnit_Framework_TestCase
{
    public function testMinasGeraisStateInBrazil()
    {
        $country = new Country;
        $brazil = $country->getByCode('BR');
        $minasGerais = $brazil->getAdministrativeAreas()->getByCode('MG');

        $this->assertEquals($minasGerais->getName(), 'Minas Gerais');
    }

    public function testAlabamaCodeByName()
    {
        $country = new Country;
        $us = $country->getByCode('US');
        $alabama = $us->getAdministrativeAreas()->getByName('Alabama');

        $this->assertEquals($alabama->getCode(), 'AL');
    }
}