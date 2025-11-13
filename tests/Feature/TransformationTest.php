<?php

namespace mmerlijn\msgRepo\tests\Feature;


use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Contact;
use mmerlijn\msgRepo\Enums\ValueType;
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
                ->setAddress(new Address(city: 'Amsterdam', street: 'D. Street'))
                ->setName(new Name(lastname: 'Doe'))
                ->setOrganisation(new Organisation(name: 'XILE')))
            ->setOrder((new Order())
                ->addRequest((new Request(test: ["CRP", "CRP",  "99zdl"]))
                    ->addResult((new Result(type: ValueType::CE, test: ["COVIDURG",  "Urgentie?",  "99zdl"]))
                        ->addValue(["","Binnen 6 maanden", "99zda"]))));

        $array = $msg->toArray();
        $msg2 = (new Msg())->fromArray($array);
        $this->assertSame($array, $msg2->toArray());

        $msg3 = (new Msg())->fromJson($msg->toJson());
        $this->assertSame($msg->toArray(), $msg3->toArray());

    }
}
