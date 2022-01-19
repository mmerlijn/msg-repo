<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\OrderItem;

class OrderTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_set_order()
    {
        $order = new Order();
        $order->requester->name->lastname = "Doe";
        $order->addComment('This is fun');
        $order->addItem(new OrderItem(value: 20, test_name: 'CODAC'));
        $array = $order->toArray();
        $this->assertArrayHasKey('comments', $array);
        $this->assertSame('This is fun', $array['comments'][0]);
        $this->assertSame('CODAC', $order->orderItems[0]->test_name);
    }
}