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
        $name = new Name(name: "P. van der Vaart", sex: PatientSexEnum::MALE);
        $this->assertSame('P', $name->initials);
        $this->assertSame('van der', $name->own_prefix);
        $this->assertSame('Vaart', $name->own_lastname);
        $name = new Name(name: "P van der Vaart", sex: PatientSexEnum::MALE);
        $this->assertSame('P', $name->initials);
        $this->assertSame('van der', $name->own_prefix);
        $this->assertSame('Vaart', $name->own_lastname);
        $name = new Name(name: "P Vaart van der-de Groen", sex: PatientSexEnum::FEMALE);
        $this->assertSame('P', $name->initials);
        $this->assertSame('van der', $name->prefix);
        $this->assertSame('Vaart', $name->lastname);
        $name = new Name(name: "Mevr. P Vaart van der-de Groen", sex: PatientSexEnum::FEMALE);
        $this->assertSame('P', $name->initials);
        $this->assertSame('van der', $name->prefix);
        $this->assertSame('Vaart', $name->lastname);
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

    public function test_name_format()
    {
        $name = new Name();
        $name->initials = "AB.";
        $name->lastname = "van der velden";
        $name->own_lastname = "de Groot";
        $name->own_prefix = "";
        $name->format();
        $this->assertSame('AB', $name->initials);
        $this->assertSame('van der', $name->prefix);
        $this->assertSame('de', $name->own_prefix);
        $this->assertSame("Velden", $name->lastname);
        $this->assertSame("Groot", $name->own_lastname);
        $this->assertSame('A.B. van der Velden - de Groot', $name->name);
    }

    public function test_get_name_format2()
    {
        $name = new Name();
        $name->initials = "A";
        $name->own_lastname = "Das";
        $name->name = "Das";
        $name->format();
        $this->assertSame('A', $name->initials);
        $this->assertSame("Das", $name->own_lastname);
        $this->assertSame('A. Das', $name->name);
    }

    public function test_changing_name()
    {
        $name = new Name(name: "de Graaf-van Wege", own_prefix: "van", own_lastname: 'Wege', prefix: "de", lastname: "Graaf");
        $name->initials = "AB.34";
        $name->lastname = "van der velden";
        $name->prefix = "";
        $name->own_lastname = "de Groot";
        $name->own_prefix = "";
        $name->format();
        $this->assertSame('AB', $name->initials);
        $this->assertSame('van der', $name->prefix);
        $this->assertSame('de', $name->own_prefix);
        $this->assertSame("Velden", $name->lastname);
        $this->assertSame("Groot", $name->own_lastname);
        $this->assertSame('A.B. van der Velden - de Groot', $name->name);
    }

    public function test_salutation()
    {
        $name = new Name(own_lastname: "Doe", lastname: "Cloud", initials: 'J.F.', own_prefix: "de", sex: PatientSexEnum::MALE);
        $array = $name->toArray();
        $this->assertSame('M', $array['sex']);
        $this->assertSame('Dhr. ', $array['salutation']);
        $this->assertSame('Dhr. ', $name->salutation);
    }

    //test null lastname
    public function test_null_lastname()
    {
        $name = new Name(own_lastname: 'Doe', lastname: null, initials: 'J', prefix: null, name: null, salutation: null);
        $array = $name->toArray();
        $this->assertSame("", $array['lastname']);
    }

    public function test_format()
    {
        $name = new Name(own_lastname: "Sier***", lastname: 'Vis*ws*');
        $array = $name->toArray();
        $this->assertSame('Sier', $array['own_lastname']);
        $this->assertSame('Vis', $array['lastname']);
    }
}