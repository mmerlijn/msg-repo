<?php

namespace mmerlijn\msgRepo\tests\Unit;

use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;
use mmerlijn\msgRepo\Order;
use mmerlijn\msgRepo\Request;
use mmerlijn\msgRepo\Observation;
use mmerlijn\msgRepo\TestCode;

class OrderTest extends \mmerlijn\msgRepo\tests\TestCase
{
    public function test_set_order()
    {
        $order = new Order();
        $order->requester->name->lastname = "Doe";
        $order->addRequest(new Request(observations: [new Observation(value: 20, test: new TestCode(value: 'CODAC'))]));
        $array = $order->toArray();
        $this->assertArrayHasKey('requests', $array);
        $this->assertSame('CODAC', $order->requests[0]->observations[0]->test->value);
    }


    public function test_add_multiple_observations()
    {
        $order = (new Order())->addRequest(new Request(test: new TestCode(code: "GG", value: "Test ABC")));
        $order->addObservation(new Observation(test: new TestCode(code: "ABD", value: "Test ABD")), 'all');
        $this->assertSame(1, count($order->requests));
        $order->addObservation(new Observation(test: new TestCode( code:"CBA")),'x');
        $this->assertSame(1, count($order->requests));
    }

    public function test_add_dubble_observation()
    {
        $order = (new Order())->addRequest(new Request(test: new TestCode(code: "GG", value: "Test ABC")));
        $order->addObservation(new Observation(test: new TestCode(code: "ABD", value: "Test ABD")), 'all');
        $order->addObservation(new Observation(test: new TestCode(code: "ABD", value: "Test ABD")), 'all');
        $this->assertSame(1, count($order->requests));

    }

    public function test_add_dubble_request()
    {
        $order = new Order();
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $this->assertSame(1, count($order->requests));
    }

    public function test_filter_by_testcode()
    {
        $order = new Order();
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $order->addRequest(new Request(test: new TestCode(code: "ABB")));
        $order->addRequest(new Request(test: new TestCode(code: "ABD")));
        $order->addRequest(new Request(test: new TestCode(code: "ABE")));
        $order->filterTestCodes(["ABD", "ABE", "AAA"]);
        $this->assertSame(2, count($order->requests));
    }

    public function test_get_testcodes()
    {
        $order = new Order();
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $order->addRequest(new Request(test: new TestCode(code: "ABD")));
        $order->addRequest(new Request(test: new TestCode(code: "ABE")));
        $this->assertSame(["ABC", "ABD", "ABE"], $order->getRequestedTestcodes());
    }

    public function test_get_filtered_testcodes()
    {
        $order = new Order();
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $order->addRequest(new Request(test: new TestCode(code: "ABD")));
        $order->addRequest(new Request(test: new TestCode(code: "ABE")));
        $this->assertSame(["ABC", "ABE"], $order->getRequestedTestcodes('ABD'));

        $order = new Order();
        $order->addRequest(new Request(test: new TestCode(code: "ABC")));
        $order->addRequest(new Request(test: new TestCode(code: "ABD")));
        $order->addRequest(new Request(test: new TestCode(code: "ABE")));
        $this->assertSame(["ABE"], $order->getRequestedTestcodes(['ABD', 'ABC']));
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
        $this->assertSame('L', $order->where->getHl7());
    }

    public function test_getResult()
    {
        $order = (new Order())->addRequest(new Request(test: new TestCode(code: "GG", value: "Test ABC")));
        $order->addObservation(new Observation(test: new TestCode(code: "ABC")));
        $order->addObservation(new Observation(test: new TestCode(code: "ABD")));
        $order->addObservation(new Observation(test: new TestCode(code: "ABE")));
        $this->assertSame("ABC", $order->getObservationByTestcode("ABC")->test->code);
        $this->assertSame("ABD", $order->getObservationByTestcode("ABD")->test->code);
        $this->assertSame("ABE", $order->getObservationByTestcode("ABE")->test->code);
        $this->assertNull($order->getObservationByTestcode("ABF"));
    }

}