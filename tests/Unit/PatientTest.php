<?php

namespace mmerlijn\msgRepo\tests\Unit;

use Carbon\Carbon;
use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Id;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Patient;
use mmerlijn\msgRepo\tests\TestCase;
use phpDocumentor\Reflection\Type;


class PatientTest extends TestCase
{
    public function test_patient_setter()
    {
        $patient = new Patient(name: new Name(), address: new Address(postcode: "1040AB"), dob: Carbon::now()->subYears(34)->startOfDay());
        $patient->name->lastname = "Doe";
        $this->assertSame("1040AB", $patient->address->postcode);
        $this->assertIsArray($patient->toArray());
        $this->assertArrayHasKey('dob', $patient->toArray());
    }

    public function test_bsn_setter()
    {
        $p = new Patient();
        $p->setBsn("123456782");
        $this->assertSame("123456782", $p->bsn);
        $this->assertSame("123456782", $p->ids[0]->id);
    }

    public function test_bsn_getter()
    {
        $p = new Patient();
        $p->bsn = "123456782";
        $this->assertSame("123456782", $p->getBsn());
        $p = new Patient();
        $p->addId(new Id(type: 'bsn', id: "123456783"));
        $this->assertSame("123456783", $p->getBsn());
    }

    public function test_name_setter()
    {
        $p = new Patient();
        $p->setName(['lastname' => 'Doe', 'initials' => 'J']);
        $this->assertSame('Doe', $p->name->lastname);
        $this->assertSame('J', $p->name->initials);
    }

    public function test_bsn_first()
    {
        $p = new Patient();
        $p->addId(new Id(id: 'ZD12341234', authority: "zorgdomein", code: "VN"));
        $p->addId(new Id(id: '123456782', type: 'bsn'));

        $this->assertSame('123456782', $p->ids[0]->id);
        $this->assertSame('ZD12341234', $p->ids[1]->id);
        $this->assertSame(2, count($p->ids));
        $this->assertSame("123456782", $p->bsn);
    }

    public function test_bsn_first2()
    {
        $p = new Patient();
        $p->addId(new Id(id: '123456782', type: 'bsn'));
        $p->addId(new Id(id: 'ZD12341234', authority: "zorgdomein", code: "VN"));


        $this->assertSame('123456782', $p->ids[0]->id);
        $this->assertSame('ZD12341234', $p->ids[1]->id);
        $this->assertSame(2, count($p->ids));
        $this->assertSame("123456782", $p->bsn);
    }
}