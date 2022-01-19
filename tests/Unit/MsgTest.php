<?php

namespace mmerlijn\msgRepo\tests\Unit;

use Carbon\Carbon;
use mmerlijn\msgRepo\Msg;
use mmerlijn\msgRepo\Patient;
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

    public function test_print()
    {
        $msg = new Msg();
        print_r($msg->toArray());
    }


}