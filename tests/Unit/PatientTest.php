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
}