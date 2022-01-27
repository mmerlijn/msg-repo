<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\tests\TestCase;

class NameTest extends TestCase
{
    public function test_name_setter()
    {
        $name = new Name(own_lastname: "Doe", lastname: "Cloud", initials: 'J.F.', own_prefix: "de");
        $this->assertSame($name->own_lastname, "Doe");
        $this->assertArrayHasKey('lastname', $name->toArray());
        $this->assertSame('JF', $name->initials);
        $this->assertSame("Cloud - de Doe", $name->getLastnames());
    }

    public function test_splitter()
    {
        $name = new Name(name: "Doe van der");
        $this->assertSame("van der", $name->own_prefix);
        $this->assertSame("Doe", $name->own_lastname);

        $name = new Name(name: "Doe, van der");
        $this->assertSame("van der", $name->own_prefix);
        $this->assertSame("Doe", $name->own_lastname);

        $name = new Name(name: "van der Vaart - de Groen");
        $this->assertSame("van der", $name->prefix);
        $this->assertSame("Vaart", $name->lastname);
        $this->assertSame("de", $name->own_prefix);
        $this->assertSame("Groen", $name->own_lastname);

        $name = new Name(name: "van der Vaart-de Groen");
        $this->assertSame("van der", $name->prefix);
        $this->assertSame("Vaart", $name->lastname);
        $this->assertSame("de", $name->own_prefix);
        $this->assertSame("Groen", $name->own_lastname);

        $name = new Name(name: "Vaart van der-de Groen");
        $this->assertSame("van der", $name->prefix);
        $this->assertSame("Vaart", $name->lastname);
        $this->assertSame("de", $name->own_prefix);
        $this->assertSame("Groen", $name->own_lastname);
    }
}