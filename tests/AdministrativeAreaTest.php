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
        $brazil = $country->findByCode('BR');
        $minasGerais = $brazil->getAdministrativeAreas()->findByCode('MG');

        $this->assertEquals($minasGerais->getName(), 'Minas Gerais');
    }

    public function testAlabamaCodeByName()
    {
        $country = new Country;
        $us = $country->findByCode('US');
        $alabama = $us->getAdministrativeAreas()->findByName('Alabama');

        $this->assertEquals($alabama->getCode(), 'AL');
    }
}