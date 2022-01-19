<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\tests\TestCase;

class AddressTest extends TestCase
{
    public function test_set_address()
    {
        $address = new Address(building: "56 a", street: "Long Street", city: "Amsterdam", postcode: "1040AB", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('56', $address->building_nr);
        $this->assertSame('a', $address->building_addition);
        $this->assertIsArray($address->toArray());
        $this->assertArrayHasKey('postcode', $address->toArray());
    }
}