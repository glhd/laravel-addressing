<?php

use Galahad\LaravelAddressing\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Galahad\LaravelAddressing\Locality;

/**
 * Class LocalityTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class LocalityTest extends PHPUnit_Framework_TestCase
{
    public function testBeloHorizonteCity()
    {
        $brazil = (new Country)->getByCode('BR');
        $states = $brazil->getAdministrativeAreas();
        $minasGerais = $states->getByCode('MG');
        $beloHorizonte = $minasGerais->getLocalities()->getByName('Belo Horizonte');

        $this->assertEquals($beloHorizonte->getAdministrativeArea()->getName(), 'Minas Gerais');
        $this->assertEquals($beloHorizonte->getName(), 'Belo Horizonte');
        $this->assertInstanceOf(Locality::class, $beloHorizonte);
    }

    public function testGetMagicMethod()
    {
        $maker = new LaravelAddressing();
        $city = $maker->country('BR')->state('MG')->city('Belo Horizonte');

        $this->assertEquals($city->name, 'Belo Horizonte');
    }

//    public function testBoulderCity()
//    {
//        $colorado = (new Country)->getByCode('US')->getAdministrativeAreas()->getByName('Colorado');
//
//        $this->assertEquals($colorado->getLocalities()->getByName('Boulder'), 'Boulder');
//    }
}