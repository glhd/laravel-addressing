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
}