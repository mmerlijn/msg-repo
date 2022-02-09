<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;
use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\Request;
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

    public function test_add_result_with_comment()
    {
        $order = new Order();
        $order->addResult(new Result());
        $order->results[0]->addComment("Hello World");
        $this->assertSame("Hello World", $order->results[0]->comments[0]);
    }

    public function test_add_dubble_result()
    {
        $order = new Order();
        $order->addResult(new Result(test_code: "ABC"));
        $order->addResult(new Result(test_code: "ABC"));
        $this->assertSame(1, count($order->results));
    }

    public function test_add_dubble_request()
    {
        $order = new Order();
        $order->addRequest(new Request(test_code: "ABC"));
        $order->addRequest(new Request(test_code: "ABC"));
        $this->assertSame(1, count($order->requests));
    }

    public function test_filter_by_testcode()
    {
        $order = new Order();
        $order->addRequest(new Request(test_code: "ABC"));
        $order->addRequest(new Request(test_code: "ABD"));
        $order->addRequest(new Request(test_code: "ABE"));
        $order->filterTestCodes(["ABD", "ABE", "AAA"]);
        $this->assertSame(1, count($order->requests));
    }

    public function test_get_testcodes()
    {
        $order = new Order();
        $order->addRequest(new Request(test_code: "ABC"));
        $order->addRequest(new Request(test_code: "ABD"));
        $order->addRequest(new Request(test_code: "ABE"));
        $this->assertSame(["ABC", "ABD", "ABE"], $order->getRequestedTestcodes());
    }

    public function test_control()
    {
        $order = new Order();
        $order->control = OrderControlEnum::NEW;
        $this->assertSame("NEW", $order->control->value);
        $order = new Order();
        $order->control = OrderControlEnum::set("Ca");
        $this->assertSame("CANCEL", $order->control->value);
        $this->assertSame('CANCEL', $order->toArray()['control']);
    }

    public function test_where()
    {
        $order = new Order();
        $order->where = OrderWhereEnum::HOME;
        $this->assertSame("HOME", $order->where->value);
        $order = new Order();
        $order->where = OrderWhereEnum::set("l");
        $this->assertSame("HOME", $order->where->value);
        $this->assertSame('HOME', $order->toArray()['where']);
    }
}