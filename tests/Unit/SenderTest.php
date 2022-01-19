<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Sender;

class SenderTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_sender_setter()
    {
        $sender = new Sender(name: "ABC", facility: 'downup');

        $this->assertSame('ABC', $sender->name);
        $this->assertArrayHasKey('application', $sender->toArray());
    }
}