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
}