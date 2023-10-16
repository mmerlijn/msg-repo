<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\tests\TestCase;

class AddressTest extends TestCase
{
    public function test_set_address()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "56 a", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('56', $address->building_nr);
        $this->assertSame('a', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertIsArray($address->toArray());
        $this->assertArrayHasKey('postcode', $address->toArray());
    }

    public function test_set_address_with_street_building()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4", building: "a/b", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('4', $address->building_nr);
        $this->assertSame('a/b', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());
    }

    public function test_with_strange_street()
    {
        $address = new Address(building: "3a/b", street: "1e Long Street", city: "AMSTERDAM", postcode: "1040AB", country: "NL");
        $this->assertSame('1e Long Street', $address->street);
        $this->assertSame('3', $address->building_nr);
        $this->assertSame('a/b', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());
    }

    public function test_with_building_and_building_nr()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "3a/b", building_nr: "3", building_addition: "a/b", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('3', $address->building_nr);
        $this->assertSame('a/b', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());

    }

    public function test_with_building_nr_and_addition()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building_nr: "3", building_addition: "a/b", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('3', $address->building_nr);
        $this->assertSame('a/b', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());
    }

    public function test_with_building_contains_addition()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107 1",);
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('107', $address->building_nr);
        $this->assertSame('1', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());

        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107 a",);
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('107', $address->building_nr);
        $this->assertSame('a', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());

        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107-1",);
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('107', $address->building_nr);
        $this->assertSame('1', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());

        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street", building: "107-a",);
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('107', $address->building_nr);
        $this->assertSame('a', $address->building_addition);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());
    }

    public function test_with_street()
    {
        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4 A", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('4', $address->building_nr);
        $this->assertSame('A', $address->building_addition);
        $this->assertSame('4 A', $address->building);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());

        $address = new Address(postcode: "1040AB", city: "AMSTERDAM", street: "Long Street 4 1", country: "NL");
        $this->assertSame('Long Street', $address->street);
        $this->assertSame('4', $address->building_nr);
        $this->assertSame('1', $address->building_addition);
        $this->assertSame('4 1', $address->building);
        $this->assertSame('Amsterdam', $address->city);
        $this->assertArrayHasKey('postcode', $address->toArray());
    }
}