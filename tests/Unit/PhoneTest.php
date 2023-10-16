<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Phone;

class PhoneTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_phones_setter()
    {

        $p = new Phone("06 1234 1234");
        $this->assertSame("0612341234", $p->number);
        $this->assertSame("06 1234 1234", (string)$p);

        $p = new Phone("0299123456");
        $this->assertSame("0299123456", $p->number);
        $this->assertSame("0299 123 456", (string)$p);

        $p = new Phone("+31299123456");
        $this->assertSame("0299123456", $p->number);
        $this->assertSame("0299 123 456", (string)$p);

        $p = new Phone("0031299123456");
        $this->assertSame("0299123456", $p->number);
        $this->assertSame("0299 123 456", (string)$p);
    }

    public function test_add_country_code()
    {
        $p = new Phone("0612341234");
        $this->assertSame("+31612341234", $p->withCountryCode());
    }

    public function test_for_sms()
    {
        $p = new Phone("0612341234");
        $this->assertSame("+31612341234", $p->forSms());
    }

    public function test_city_netnumbers()
    {
        $p = new Phone("1234567");
        $p->netNumber('Amsterdam');
        $this->assertSame("0201234567", $p->number);

        $p = new Phone("1234567");
        $p->netNumber('DoesNotExist');
        $this->assertSame("1234567", $p->number);

        //changing
        $p = (new Phone("1234567"))->netNumber("Amsterdam");
        $this->assertSame("0201234567", $p->number);

        //empty number stays empty
        $p = (new Phone())->netNumber("Amsterdam");
        $this->assertSame("", $p->number);
    }

    public function test_nb_phone()
    {
        $p = new Phone("nb");
        $this->assertSame('nb', $p->number);

        $p = new Phone(" nb ");
        $this->assertSame('nb', $p->number);

        $p = new Phone("nb123");
        $this->assertSame('123', $p->number);
    }


}