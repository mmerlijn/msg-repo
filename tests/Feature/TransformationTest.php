<?php

namespace mmerlijn\msgRepo\tests\Feature;


use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Contact;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\Organisation;
use mmerlijn\msgRepo\Patient;
use mmerlijn\msgRepo\Request;
use mmerlijn\msgRepo\Result;
use PHPUnit\Framework\TestCase;

class TransformationTest extends TestCase
{
    public function test_to_array()
    {
        $msg = (new Msg())
            ->setPatient((new Patient())->setDob("10-11-2004")->setName(['name' => 'John Doe']))
            ->setReceiver((new Contact())
                ->setPhone("0612341234")
                ->setAddress(new Address(street: 'D. Street', city: 'Amsterdam'))
                ->setName(new Name(lastname: 'Doe'))
                ->setOrganisation(new Organisation(name: 'XILE')))
            ->setOrder((new Order())
                ->addRequest((new Request(test_code: "CRP", test_name: "CRP", test_source: "99zdl")))
                ->addResult((new Result(value: "6 mnd", test_code: "COVIDURG", test_source: "99zdl", test_name: "Urgentie?", other_test_name: "Binnen 6 maanden", other_test_source: "99zda"))));
        $array = $msg->toArray();
        $msg2 = (new Msg())->fromArray($array);
        $this->assertSame($msg->toArray(), $msg2->toArray());

        $msg3 = (new Msg())->fromJson($msg->toJson());
        $this->assertSame($msg->toArray(), $msg3->toArray());

    }
}
