<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Phone;
use mmerlijn\msgRepo\Phones;

class PhonesTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_phones_setter()
    {

        $p = (new Phones())->add(new Phone("0123456789"))->add(new Phone("0123456789"));
        $this->assertSame("0123456789", (string)$p->phones[0]);

        //double not stored twice
        $this->assertSame(1, count($p->phones));
    }
}