<?php

namespace mmerlijn\msgRepo\tests\Unit;

use Carbon\Carbon;
use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Contact;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Organisation;
use mmerlijn\msgRepo\Patient;
use mmerlijn\msgRepo\Receiver;
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
    }


    public function test_chaining()
    {
        $msg = (new Msg())
            ->setPatient((new Patient())->setDob("10-11-2004"))
            ->setReceiver((new Contact())
                ->setPhone("0612341234")
                ->setAddress(new Address(street: 'D. Street', city: 'Amsterdam'))
                ->setName(new Name(lastname: 'Doe'))
                ->setOrganisation(new Organisation(name: 'XILE')));
        $this->assertSame("2004-11-10", $msg->patient->dob->format("Y-m-d"));
        $this->assertSame('06 1234 1234', (string)$msg->receiver->phone);
        $this->assertSame("D. Street", $msg->receiver->address->street);
        $this->assertSame("XILE", $msg->receiver->organisation->name);
        $this->assertSame("Doe", $msg->receiver->name->lastname);
    }

    //public function test_print_for_docs()
    //{
    //    $msg = new Msg();
    //    print_r($msg->toArray());
    //}
}