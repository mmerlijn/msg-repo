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
        $this->assertSame("0612341234", (string)$contact->phone);
        $this->assertSame("Doe", $contact->name->lastname);
        $contact->setPhone("0611223344");
        $this->assertSame("0611223344", (string)$contact->phone);
    }

    public function test_chaining()
    {
        $contact = (new Contact())
            ->setPhone("0612341234")
            ->setAddress(new Address(street: 'D. Street', city: 'Amsterdam'))
            ->setName(new Name(lastname: 'Doe'))
            ->setOrganisation(new Organisation(name: 'XILE'));
        $this->assertSame('0612341234', (string)$contact->phone);
        $this->assertSame("D. Street", $contact->address->street);
        $this->assertSame("XILE", $contact->organisation->name);
        $this->assertSame("Doe", $contact->name->lastname);
    }
}