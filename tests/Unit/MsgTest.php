<?php

namespace mmerlijn\msgRepo\tests\Unit;

use Carbon\Carbon;
use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Contact;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Organisation;
use mmerlijn\msgRepo\Patient;
use mmerlijn\msgRepo\tests\TestCase;

class MsgTest extends TestCase
{
    public function test_msg_setter()
    {
        $msg = new Msg(patient: new Patient(), datetime: Carbon::now(), id: "1234567890");
        $msg->patient->name->own_lastname = "Doe";
        $this->assertIsArray($msg->toArray());

    }

    public function test_add_bsn()
    {
        $msg = new Msg();
        $msg->patient->setBsn("123456782");
        $this->assertSame("123456782", $msg->patient->bsn);
        $this->assertSame("123456782", $msg->patient->ids[0]->id);
        $this->assertSame("NLMINBIZA", $msg->patient->ids[0]->authority);
    }


    public function test_chaining()
    {
        $msg = (new Msg())
            ->setPatient((new Patient())->setDob("10-11-2004"))
            ->setReceiver((new Contact())
                ->setPhone("0612341234")
                ->setAddress(new Address(city: 'Amsterdam', street: 'D. Street'))
                ->setName(new Name(lastname: 'Doe'))
                ->setOrganisation(new Organisation(name: 'XILE')));
        $this->assertSame("2004-11-10", $msg->patient->dob->format("Y-m-d"));
        $this->assertSame('06 1234 1234', (string)$msg->receiver->phone);
        $this->assertSame("D. Street", $msg->receiver->address->street);
        $this->assertSame("XILE", $msg->receiver->organisation->name);
        $this->assertSame("Doe", $msg->receiver->name->lastname);
    }

    public function test_compact()
    {
        $msg = (new Msg())
            ->setPatient((new Patient())->setDob("10-11-2004"))
            ->setReceiver((new Contact())
                ->setPhone("0612341234")
                ->setAddress(new Address(city: 'Amsterdam', street: 'D. Street'))
                ->setName(new Name(lastname: 'Doe'))
                ->setOrganisation(new Organisation(name: 'XILE')));
        $this->assertIsArray($msg->toArray(true));
        $this->assertArrayHasKey('patient', $msg->toArray(true));
        $this->assertArrayHasKey('receiver', $msg->toArray(true));
        $this->assertArrayHasKey('phone', $msg->toArray(true)['receiver']);
        $this->assertArrayHasKey('address', $msg->toArray(true)['receiver']);
        $this->assertArrayHasKey('name', $msg->toArray(true)['receiver']);
        $this->assertArrayHasKey('organisation', $msg->toArray(true)['receiver']);
        $this->assertArrayHasKey('street', $msg->toArray(true)['receiver']['address']);
        $this->assertArrayHasKey('name', $msg->toArray(true)['receiver']['organisation']);
        $this->assertArrayHasKey('lastname', $msg->toArray(true)['receiver']['name']);
        $this->assertArrayNotHasKey('postcode', $msg->toArray(true)['receiver']['address']);
        $this->assertArrayNotHasKey('orders', $msg->toArray(true));
        $msg = new Msg(...$msg->toArray(true));
        $this->assertSame("2004-11-10", $msg->patient->dob->format("Y-m-d"));
        $this->assertSame('06 1234 1234', (string)$msg->receiver->phone);
    }
}