<?php

namespace mmerlijn\msgRepo\tests\Unit;

use Carbon\Carbon;
use mmerlijn\msgRepo\Address;
use mmerlijn\msgRepo\Name;
use mmerlijn\msgRepo\Patient;
use mmerlijn\msgRepo\tests\TestCase;


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
}