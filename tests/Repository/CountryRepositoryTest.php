<?php

use Galahad\LaravelAddressing\Repository\CountryRepository;

/**
 * Class CountryRepositoryTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class CountryRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testGetList()
    {
        $countryRepository = new CountryRepository();
        $countries = $countryRepository->getList('en');

        $this->assertTrue(isset($countries['BR']));
        $this->assertEquals($countries['BR'], 'Brazil');
        $this->assertTrue(isset($countries['US']));
        $this->assertEquals($countries['US'], 'United States');
    }
}