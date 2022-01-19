<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Receiver;
use mmerlijn\msgRepo\Sender;

class ReceiverTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_receiver_setter()
    {
        $receiver = new Receiver(name: "ABC", facility: 'downup');

        $this->assertSame('ABC', $receiver->name);
        $this->assertArrayHasKey('application', $receiver->toArray());
    }
}