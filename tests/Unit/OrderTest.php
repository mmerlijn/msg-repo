<?php

namespace mmerlijn\msgRepo\tests\Unit;

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
}