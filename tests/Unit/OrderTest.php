<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\OrderItem;
use mmerlijn\msgRepo\Result;

class OrderTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_set_order()
    {
        $order = new Order();
        $order->requester->name->lastname = "Doe";
        $order->addComment('This is fun');
        $order->addResult(new Result(value: 20, test_name: 'CODAC'));
        $array = $order->toArray();
        $this->assertArrayHasKey('comments', $array);
        $this->assertSame('This is fun', $array['comments'][0]);
        $this->assertSame('CODAC', $order->results[0]->test_name);
    }

    public function test_set_orderItems()
    {
        $order = new Order();
        $order->addResult(new Result());
        $order->results[0]->addComment("Hello World");
        $this->assertSame("Hello World", $order->results[0]->comments[0]);
    }
}