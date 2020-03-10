<?php

namespace Galahad\LaravelAddressing\Tests;

use Galahad\LaravelAddressing\Support\Facades\Addressing;

class SubdivisionEntityTest extends TestCase
{
    public function test_subdivisions_expose_their_country(): void
    {
        $usa = Addressing::country('US');
        $colorado = $usa->administrativeArea('CO');
        $pennsylvania = $usa->administrativeArea('PA');

        $this->assertTrue($colorado->getCountry()->is($pennsylvania->getCountry()));
    }

    public function test_subdivisions_can_be_compared(): void
    {
        $usa = Addressing::country('US');
        $colorado = $usa->administrativeArea('CO');
        $colorado2 = $usa->administrativeArea('CO');
        $pennsylvania = $usa->administrativeArea('PA');

        $this->assertTrue($colorado->is($colorado2));
        $this->assertFalse($colorado->is($pennsylvania));
    }
}
