<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Contact;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Organisation;
use mmerlijn\msgRepo\Phone;

class ContactTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_set_method()
    {
        $contact = new Contact();

        $contact->setPhone(new Phone("0612341234"));
        $contact->setName(new Name(lastname: 'Doe'));
        $this->assertSame("0612341234", $contact->phone->number);
        $this->assertSame("06 1234 1234", (string)$contact->phone);
        $this->assertSame("Doe", $contact->name->lastname);
        $contact->setPhone("0611223344");
        $this->assertSame("06 1122 3344", (string)$contact->phone);
    }

    public function test_chaining()
    {
        $contact = (new Contact())
            ->setPhone("0612341234")
            ->setAddress(new Address(street: 'D. Street', city: 'Amsterdam'))
            ->setName(new Name(lastname: 'Doe'))
            ->setOrganisation(new Organisation(name: 'XILE'));
        $this->assertSame('06 1234 1234', (string)$contact->phone);
        $this->assertSame("D. Street", $contact->address->street);
        $this->assertSame("XILE", $contact->organisation->name);
        $this->assertSame("Doe", $contact->name->lastname);
    }

    public function test_compact()
    {
        $contact = (new Contact())
            ->setPhone("0612341234")
            ->setAddress(new Address(city: 'Amsterdam', street: 'D. Street'))
            ->setName(new Name(lastname: 'Doe'))
            ->setOrganisation(new Organisation(name: 'XILE'));
        $this->assertIsArray($contact->toArray(true));
        $this->assertArrayHasKey('phone', $contact->toArray(true));
        $this->assertArrayHasKey('address', $contact->toArray(true));
        $this->assertArrayHasKey('name', $contact->toArray(true));
        $this->assertArrayHasKey('organisation', $contact->toArray(true));
        $this->assertArrayHasKey('street', $contact->toArray(true)['address']);
        $this->assertArrayHasKey('name', $contact->toArray(true)['organisation']);
        $this->assertArrayHasKey('lastname', $contact->toArray(true)['name']);
        $this->assertArrayNotHasKey('postcode', $contact->toArray(true)['address']);
        $this->assertArrayNotHasKey('sex', $contact->toArray(true));
    }
}