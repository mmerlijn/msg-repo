<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Insurance;

class InsuranceTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_insurance_setter()
    {
        $ins = new Insurance(uzovi: '1234', company_name: "ABC", policy_nr: "123412312423");
        $this->assertSame($ins->policy_nr, "123412312423");
        $this->assertArrayHasKey('company_name', $ins->toArray());
    }

    public function test_compact()
    {
        $data = ['uzovi' => '1234', 'company_name' => ""];
        $ins = new Insurance(...$data);
        $this->assertSame([
            'uzovi' => '1234',
        ], $ins->toArray(true));

        $data = ['uzovi' => '1234', 'company_name' => "Bla"];
        $ins = new Insurance(...$data);
        $this->assertSame([
            'uzovi' => '1234',
            'company_name' => 'Bla',
        ], $ins->toArray(true));
    }

    public function test_setter()
    {
        $data = ['uzovi' => '1234', 'company_name' => "ABC", 'phone' => '1234567890', 'address' => ['street' => 'Straat', 'building' => '1', 'city' => 'Stad', 'postcode' => '1234AB']];
        $ins = new Insurance(...$data);
        $this->assertSame($ins->policy_nr, "");
        $this->assertSame($ins->company_name, "ABC");
        $this->assertSame($ins->phone->number, "1234567890");
        $this->assertSame($ins->address->street, "Straat");
        $this->assertSame($ins->address->building, "1");
        $this->assertSame($ins->address->city, "Stad");
        $this->assertSame($ins->address->postcode, "1234AB");
    }
}