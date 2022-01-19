<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\tests\TestCase;

class NameTest extends TestCase
{
    public function test_name_setter()
    {
        $name = new Name(own_lastname: "Doe", lastname: "Cloud", initials: 'JF');
        $this->assertSame($name->own_lastname, "Doe");
        $this->assertArrayHasKey('lastname', $name->toArray());
    }
}