<?php

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;

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
        $alabama2 = $us->states()->name('Alabama');

        $this->assertEquals($alabama->getCode(), 'AL');
        $this->assertEquals($alabama2->getCode(), 'AL');
    }

    public function testGetMagicMethod()
    {
        $maker = new LaravelAddressing();
        $firstState = $maker->country('US')->states()->getByKey(0);

        $this->assertEquals($firstState->name, 'Alabama');
    }
}