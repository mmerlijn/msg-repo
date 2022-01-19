<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\MsgType;

class MsgTypeTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_msgType_setter()
    {
        $type = new MsgType(type: 'medvri');
        $this->assertSame($type->type, 'medvri');
        $this->assertArrayHasKey('type', $type->toArray());
    }
}