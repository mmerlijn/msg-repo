<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Enums\PatientSexEnum;
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

        $name = new Name(own_lastname: "Doe", lastname: "", initials: 'RAJ', own_prefix: "");
        $this->assertSame("Doe", $name->own_lastname);
        $this->assertSame('RAJ', $name->initials);
        $this->assertSame("Doe", $name->getLastnames());
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

    public function test_fullname()
    {
        $name = new Name(name: "Vaart van der-de Groen", sex: PatientSexEnum::FEMALE, initials: "P");
        $this->assertSame("Mevr. P. van der Vaart - de Groen", $name->getFullName());
        $name = new Name(name: "Vaart van der", sex: PatientSexEnum::MALE, initials: "P");
        $this->assertSame("Dhr. P. van der Vaart", $name->getFullName());
        $name = new Name(name: "Vaart van der", initials: "P");
        $this->assertSame("P. van der Vaart", $name->getFullName());
        $name = new Name(name: "Vaart van der");
        $this->assertSame("van der Vaart", $name->getFullName());
    }

    public function test_reverse_name()
    {
        $name = new Name(name: "Vaart van der-de Groen", sex: PatientSexEnum::FEMALE, initials: "P");
        $this->assertSame("Vaart van der - Groen de, P.", $name->getNameReverse());
        $name = new Name(name: "van der Vaart", sex: PatientSexEnum::FEMALE, initials: "P");
        $this->assertSame("Vaart van der, P.", $name->getNameReverse());
    }

    public function test_store_initials()
    {
        $name = new Name();
        $name->initials = "P.D.";
        $this->assertSame("PD", $name->getInitialsForStorage());

    }
}